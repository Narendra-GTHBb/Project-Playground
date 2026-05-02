from ctypes import cast, POINTER
from comtypes import CLSCTX_ALL
from pycaw.pycaw import AudioUtilities, IAudioEndpointVolume

import cv2
import mediapipe as mp
import time
import math
import numpy as np

# ================= AUDIO =================
devices = AudioUtilities.GetSpeakers()
interface = devices.Activate(
    IAudioEndpointVolume._iid_,
    CLSCTX_ALL,
    None
)

volume = cast(interface, POINTER(IAudioEndpointVolume))

# ================= CAMERA =================
cap = cv2.VideoCapture(0, cv2.CAP_DSHOW)

cap.set(cv2.CAP_PROP_FOURCC, cv2.VideoWriter_fourcc(*'MJPG'))
cap.set(cv2.CAP_PROP_FRAME_WIDTH, 640)
cap.set(cv2.CAP_PROP_FRAME_HEIGHT, 480)

time.sleep(2)

# ================= MEDIAPIPE =================
mp_hands = mp.solutions.hands
hands = mp_hands.Hands(
    max_num_hands=1,
    min_detection_confidence=0.6,
    min_tracking_confidence=0.6
)
mp_draw = mp.solutions.drawing_utils

# ================= STATE =================
locked = False
prev_lock_gesture = False
prev_mute_gesture = False

smooth_vol = 0  # smoothing
smooth_factor = 0.2

if not cap.isOpened():
    print("Tidak Bisa Membuka Kamera")
    exit()

# ================= LOOP =================
while True:
    success, img = cap.read()

    if not success or img is None:
        print("Gagal Membaca Frame")
        break

    img = cv2.flip(img, 1)

    # boost biar tetap kebaca di gelap
    img = cv2.convertScaleAbs(img, alpha=1.3, beta=20)

    img_rgb = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
    results = hands.process(img_rgb)

    # ================= GET REAL VOLUME =================
    currentVol = volume.GetMasterVolumeLevelScalar()
    volPer = currentVol * 100
    volBar = np.interp(volPer, [0, 100], [400, 200])

    if results.multi_hand_landmarks:
        for hand_landmarks in results.multi_hand_landmarks:

            mp_draw.draw_landmarks(
                img,
                hand_landmarks,
                mp_hands.HAND_CONNECTIONS
            )

            h, w, c = img.shape

            # titik jari
            x1 = int(hand_landmarks.landmark[4].x * w)   # jempol
            y1 = int(hand_landmarks.landmark[4].y * h)

            x2 = int(hand_landmarks.landmark[8].x * w)   # telunjuk
            y2 = int(hand_landmarks.landmark[8].y * h)

            # jari tengah (lock)
            y_mid_tip = hand_landmarks.landmark[12].y
            y_mid_lower = hand_landmarks.landmark[10].y

            # cek semua jari turun (mute)
            fingers = [
                hand_landmarks.landmark[8].y,
                hand_landmarks.landmark[12].y,
                hand_landmarks.landmark[16].y,
                hand_landmarks.landmark[20].y
            ]

            # visual
            cv2.circle(img, (x1, y1), 8, (255, 0, 255), -1)
            cv2.circle(img, (x2, y2), 8, (255, 0, 255), -1)
            cv2.line(img, (x1, y1), (x2, y2), (255, 0, 255), 2)

            # jarak
            length = math.hypot(x2 - x1, y2 - y1)

            # ================= LOCK =================
            middle_up = y_mid_tip < y_mid_lower

            if middle_up:
                if not prev_lock_gesture:
                    locked = not locked
                    prev_lock_gesture = True
            else:
                prev_lock_gesture = False

            # ================= MUTE (kepalan tangan) =================
            fist = all(f > hand_landmarks.landmark[6].y for f in fingers)

            if fist:
                if not prev_mute_gesture:
                    volume.SetMasterVolumeLevelScalar(0.0, None)
                    prev_mute_gesture = True
            else:
                prev_mute_gesture = False

            # ================= VOLUME CONTROL =================
            if not locked and not fist:
                volScalar = np.interp(length, [40, 150], [0, 1])

                # SNAP ke level tertentu
                snap_points = [0.25, 0.5, 0.75, 1.0]
                volScalar = min(snap_points, key=lambda x: abs(x - volScalar))

                # SMOOTHING
                smooth_vol = smooth_vol + (volScalar - smooth_vol) * smooth_factor

                volume.SetMasterVolumeLevelScalar(smooth_vol, None)

    # ================= UI =================
    color = (0, 255, 0) if volPer < 70 else (0, 0, 255)

    # background bar (hitam)
    cv2.rectangle(img, (50, 200), (85, 400), (0, 0, 0), -1)

    # outline
    cv2.rectangle(img, (50, 200), (85, 400), (255, 255, 255), 2)

    # isi
    cv2.rectangle(img, (50, int(volBar)), (85, 400), color, -1)

    # persen
    cv2.putText(img, f'{int(volPer)} %',
                (35, 440),
                cv2.FONT_HERSHEY_SIMPLEX,
                0.9, color, 2)

    # status
    status_text = "LOCKED" if locked else "UNLOCK"
    status_color = (0, 0, 255) if locked else (0, 255, 0)

    cv2.putText(img, status_text,
                (200, 50),
                cv2.FONT_HERSHEY_SIMPLEX,
                1, status_color, 3)

    cv2.imshow("Hand Volume Control", img)

    if cv2.waitKey(1) & 0xFF == 27:
        break

cap.release()
cv2.destroyAllWindows()
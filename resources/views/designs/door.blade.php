<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Metal Door with Square Tubes & Raised Top Panels</title>
  <style>
    /* 
      ========================
      PAGE & DOOR CONTAINER
      ========================
    */
    body {
      margin: 0;
      padding: 0;
      background: #eee;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    /* Main door container, 400×700 for demo. Adjust as needed. */
    .door-container {
      position: relative;
      width: 400px;
      height: 700px;
      /* Base color/texture of the door sheet */
      background:
        repeating-linear-gradient(
          45deg,
          rgba(255,255,255,0.03) 0px,
          rgba(255,255,255,0.03) 2px,
          transparent 2px,
          transparent 4px
        ),
        linear-gradient(
          135deg,
          #6b9ed1 0%,
          #4f7ea8 100%
        );
      background-blend-mode: overlay, normal;

      box-shadow: 0 8px 16px rgba(0,0,0,0.4);
    }

    /*
      ==========================
      1×1 SQUARE TUBES (10px)
      ==========================
      We represent each 1" tube as ~10px thick at this scale.
      Outer frame + internal divisions.
    */
    .tube {
      position: absolute;
      background: #6b9ed1; /* Painted metal color */
      box-shadow:
        inset 0 0 2px rgba(0,0,0,0.5),
        0 2px 4px rgba(0,0,0,0.4);
    }

    /* Outer frame tubes */
    .tube.top {
      top: 0; left: 0;
      width: 100%;
      height: 10px;
    }
    .tube.bottom {
      bottom: 0; left: 0;
      width: 100%;
      height: 10px;
    }
    .tube.left {
      top: 0; left: 0;
      width: 10px;
      height: 100%;
    }
    .tube.right {
      top: 0; right: 0;
      width: 10px;
      height: 100%;
    }

    /* Internal vertical tube at 50% width */
    .tube.vert-mid {
      top: 0;
      left: calc(50% - 5px); /* center a 10px bar at 50% */
      width: 10px;
      height: 100%;
    }

    /* Internal horizontal tubes at 25%, 50%, 75% of door height */
    .tube.horz-25 {
      left: 0;
      top: calc(25% - 5px);
      width: 100%;
      height: 10px;
    }
    .tube.horz-50 {
      left: 0;
      top: calc(50% - 5px);
      width: 100%;
      height: 10px;
    }
    .tube.horz-75 {
      left: 0;
      top: calc(75% - 5px);
      width: 100%;
      height: 10px;
    }

    /*
      ==========================
      RAISED TOP PANELS
      ==========================
      The tubes create top-left & top-right “boxes.”
      We’ll add a framed look inside those boxes to mimic a raised panel.
    */
    .panel-top-left,
    .panel-top-right {
      position: absolute;
      box-sizing: border-box;
      /* The top row is from top=0% to 25% => 25% total height = 175px. */
      height: 25%;
    }

    /* Top-left: from left=0% to 50% => 50% width = 200px. */
    .panel-top-left {
      top: 0;
      left: 0;
      width: 50%;
    }
    /* Top-right: from left=50% to 100% => another 50% width. */
    .panel-top-right {
      top: 0;
      left: 50%;
      width: 50%;
    }

    /* Outer frame of the raised panel */
    .panel-frame {
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      border: 8px solid #6b9ed1; /* same color as door/tubes */
      box-sizing: border-box;
      /* Slight 3D effect with outer shadow */
      box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    }

    /* Inner sheet inset from the frame edges */
    .panel-inner {
      position: absolute;
      top: 8px; left: 8px; right: 8px; bottom: 8px;
      background: #6b9ed1;
      /* Inset shadow to appear slightly recessed */
      box-shadow: inset 0 2px 4px rgba(0,0,0,0.3);
    }

    /*
      ==========================
      ORNAMENTS (SWIRLS)
      ==========================
      We'll place them in the middle row squares (25%-50%).
      The tubes create two squares there: middle-left & middle-right.
      We'll position each swirl near the center of that panel.
    */
    .ornament {
      position: absolute;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      border: 2px solid rgba(255,255,255,0.6);
      box-shadow: 0 0 6px rgba(0,0,0,0.3);
      transform: translate(-50%, -50%);
    }
    .ornament::before,
    .ornament::after {
      content: "";
      position: absolute;
      border: 2px solid rgba(255,255,255,0.6);
      border-radius: 50%;
      width: 28px;
      height: 28px;
    }
    .ornament::before {
      top: -14px; left: 16px;
    }
    .ornament::after {
      bottom: -14px; right: 16px;
    }

    /* 
      Positions for the middle-left & middle-right squares:
      - The middle row spans top=25% to 50%.
      - Left half is 0% to 50%, right half is 50% to 100%.
      We'll place them near the center of each sub-rectangle.
    */
    .ornament-left {
      top: 37.5%;  /* halfway between 25% and 50% => (25 + 50)/2 = 37.5 */
      left: 25%;   /* halfway between 0% and 50% => 25 */
    }
    .ornament-right {
      top: 37.5%;
      left: 75%;   /* halfway between 50% and 100% => 75 */
    }

    /*
      ==========================
      CIRCULAR HOLE
      ==========================
      Placed in the bottom-right panel (50%-75% vertically, 50%-100% horizontally).
      We'll center it roughly in that rectangle => top=62.5%, left=75%.
    */
    .circle-cutout {
      position: absolute;
      width: 40px;
      height: 40px;
      border: 2px solid rgba(255,255,255,0.6);
      border-radius: 50%;
      background: radial-gradient(circle at 40% 40%, #2c2c2c 0%, #000 70%);
      box-shadow: inset 0 0 4px rgba(255,255,255,0.2),
                  0 0 4px rgba(0,0,0,0.3);
      transform: translate(-50%, -50%);
    }
    .circle-bottom-right {
      top: 62.5%; /* halfway between 50% and 75% => 62.5 */
      left: 75%;  /* halfway between 50% and 100% => 75 */
    }
  </style>
</head>
<body>

<div class="door-container">

  <!-- 1×1 TUBES: OUTER FRAME -->
  <div class="tube top"></div>
  <div class="tube bottom"></div>
  <div class="tube left"></div>
  <div class="tube right"></div>

  <!-- 1×1 TUBES: INTERNAL DIVISIONS -->
  <div class="tube vert-mid"></div>
  <div class="tube horz-25"></div>
  <div class="tube horz-50"></div>
  <div class="tube horz-75"></div>

  <!-- RAISED TOP-LEFT PANEL -->
  <div class="panel-top-left">
    <div class="panel-frame">
      <div class="panel-inner"></div>
    </div>
  </div>

  <!-- RAISED TOP-RIGHT PANEL -->
  <div class="panel-top-right">
    <div class="panel-frame">
      <div class="panel-inner"></div>
    </div>
  </div>

  <!-- ORNAMENTS IN THE MIDDLE ROW -->
  <div class="ornament ornament-left"></div>
  <div class="ornament ornament-right"></div>

  <!-- CIRCULAR HOLE IN THE BOTTOM-RIGHT PANEL -->
  <div class="circle-cutout circle-bottom-right"></div>
</div>

</body>
</html>

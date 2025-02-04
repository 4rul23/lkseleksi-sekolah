<?php
// filepath: /C:/Users/ASUS/Documents/MODULE_SPEEDTEST_MEDIA/D1/index.php

// --------------------------
// PHP: Data Generation
// --------------------------
$names = [
  'Charlotte', 'Megan', 'Sophie', 'Emily', 'Jessica',
  'Lucy', 'Chloe', 'Olivia', 'Hannah', 'Ellie',
  'Katie', 'Ella', 'Amelia', 'Amy', 'Holly',
  'Grace', 'Alice', 'Daisy', 'Isabella', 'Paige',
  'Caitlin', 'Anna', 'Leah', 'Millie', 'Molly',
  'Oliver', 'Joseph', 'Harry', 'Joshua', 'James',
  'William', 'Samuel', 'Daniel', 'Jack', 'Thomas',
  'Matthew', 'Luke', 'Ethan', 'Lewis', 'Benjamin',
  'Mohammed', 'Callum', 'Alexander', 'Louis', 'Harrison',
  'Edward', 'Brandon', 'Jacob', 'Michael', 'Liam'
];

$data = [];
$barCount = mt_rand(5, 15);
for ($i = 0; $i < $barCount; $i++) {
  shuffle($names);
  $hue = mt_rand(0, 360);
  $data[] = [
    'name'  => array_pop($names),
    'value' => mt_rand(50, 500),
    'color' => "hsl({$hue}, 70%, 80%)"
  ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Improved Random Bar Chart</title>
  <style>
    /* --------------------------
       Global Styles
    -------------------------- */
    body {
      font-family: sans-serif;
      background-color: #fff;
      margin: 20px;
      padding: 0;
    }
    .chart-container {
      max-width: 800px;
      margin: 0 auto;
    }
    /* --------------------------
       Chart Grid Section
    -------------------------- */
    .chart-wrapper {
      position: relative;
      height: 500px;
      border-left: 2px solid #333;
      border-bottom: 2px solid #333;
      padding-left: 50px;
      margin-bottom: 20px;
    }
    .y-axis-tick {
      position: absolute;
      left: 0;
      width: 40px;
      text-align: right;
      font-size: 12px;
      transform: translateY(50%);
    }
    /* --------------------------
       Bars Section
    -------------------------- */
    .bars-container {
      position: relative;
      display: flex;
      height: 300px; /* Fixed height for bars area */
      gap: 10px;
      padding: 0 20px;
      border: 1px dashed #ddd; /* optional visual separator */
    }
    .bar {
      flex: 1;
      max-width: 60px;
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    /* The bar-fill is absolutely positioned at the bottom */
    .bar-fill {
      position: absolute;
      bottom: 0;
      width: 100%;
      transition: height 0.5s ease;
      min-height: 1px;
    }
    .bar-label {
      margin-top: 5px;
      font-size: 12px;
      text-align: center;
      position: relative; /* ensures label stays below the bar */
      z-index: 1;
    }
  </style>
</head>
<body>
  <div class="chart-container">
    <!-- Chart grid with Y-axis ticks -->
    <div class="chart-wrapper" id="chartWrapper"></div>
    <!-- Bars container appears below the chart grid -->
    <div class="bars-container" id="barsContainer"></div>
  </div>
  <script>
    // --------------------------
    // JavaScript: Chart Drawing
    // --------------------------
    // Parse PHP-generated data (encoded as JSON)
    const data = <?php echo json_encode($data); ?>;
    console.log('Data:', data);

    function drawChart(data) {
      const chartWrapper = document.getElementById('chartWrapper');
      const barsContainer = document.getElementById('barsContainer');

      // Determine maximum value for scaling (round up to nearest 100; minimum limit 500)
      let maxDataValue = Math.max(...data.map(item => item.value));
      let scaleMax = Math.ceil(maxDataValue / 100) * 100;
      if (scaleMax < 500) scaleMax = 500;

      // Create Y-axis tick labels in chartWrapper
      const tickCount = 5;
      for (let i = 0; i <= tickCount; i++) {
        const tickValue = Math.round((scaleMax / tickCount) * i);
        const tick = document.createElement('div');
        tick.className = 'y-axis-tick';
        tick.style.bottom = (i * (100 / tickCount)) + '%';
        tick.textContent = tickValue;
        chartWrapper.appendChild(tick);
      }

      // Create and append bars in the barsContainer
      data.forEach(item => {
        const bar = document.createElement('div');
        bar.className = 'bar';

        const barFill = document.createElement('div');
        barFill.className = 'bar-fill';
        // Height is computed as a percentage relative to scaleMax
        barFill.style.height = ((item.value / scaleMax) * 100) + '%';
        barFill.style.backgroundColor = item.color;

        const label = document.createElement('div');
        label.className = 'bar-label';
        label.textContent = item.name;

        bar.appendChild(barFill);
        bar.appendChild(label);
        barsContainer.appendChild(bar);
      });
    }

    // Render the chart
    drawChart(data);
  </script>
</body>
</html>

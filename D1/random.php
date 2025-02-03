<?php

$names = [
  'Charlotte',
  'Megan',
  'Sophie',
  'Emily',
  'Jessica',
  'Lucy',
  'Chloe',
  'Olivia',
  'Hannah',
  'Ellie',
  'Katie',
  'Ella',
  'Amelia',
  'Amy',
  'Holly',
  'Grace',
  'Alice',
  'Daisy',
  'Isabella',
  'Paige',
  'Caitlin',
  'Anna',
  'Leah',
  'Millie',
  'Molly',
  'Oliver',
  'Joseph',
  'Harry',
  'Joshua',
  'James',
  'William',
  'Samuel',
  'Daniel',
  'Jack',
  'Thomas',
  'Matthew',
  'Luke',
  'Ethan',
  'Lewis',
  'Benjamin',
  'Mohammed',
  'Callum',
  'Alexander',
  'Louis',
  'Harrison',
  'Edward',
  'Brandon',
  'Jacob',
  'Michael',
  'Liam'
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
<html>

<head>
  <meta charset="UTF-8">
  <title>Random Bar Chart</title>
  <style>
    body {
      font-family: sans-serif;
      background-color: #fff;
      margin: 20px;
      padding: 0;
    }

    .chart-container {
      max-width: 800px;
      margin: auto;
    }

    .chart-wrapper {
      position: relative;
      height: 500px;
      border-left: 2px solid #333;
      border-bottom: 2px solid #333;
      padding-left: 50px;
      margin-bottom: 20px;
      padding-bottom: 40px;
    }

    .y-axis-tick {
      position: absolute;
      left: 0;
      width: 40px;
      text-align: right;
      font-size: 12px;
      transform: translateY(50%);
    }

    .bars-container {
      display: flex;
      height: 100%;
      gap: 10px;
      padding-right: 20px;
      transform: rotate(180deg);
    }

    .bar {
      flex: 1;
      max-width: 60px;
      display: flex;
      flex-direction: column;
      align-items: center;
      height: 100%;

    }

    .bar-fill {
      width: 100%;
      background-color: #ccc;
      transition: height 0.5s ease;
      min-height: 1px;
    }


    .bar-value {
      margin-bottom: 5px;
      font-size: 12px;
    }

    .bar-label {
      margin-top: 8px;
      font-size: 12px;
      text-align: center;
      transform: rotate(180deg);
    }
  </style>
</head>

<body>
  <div class="chart-container">
    <div class="chart-wrapper" id="chartWrapper">
      <div class="bars-container" id="barsContainer"></div>
    </div>
  </div>
  <script>
    const data = <?php echo json_encode($data); ?>;
    console.log('Data:', data);

    function drawChart(data) {
      const chartWrapper = document.getElementById('chartWrapper');
      const barsContainer = document.getElementById('barsContainer');


      let maxDataValue = Math.max(...data.map(d => d.value));
      let scaleMax = Math.ceil(maxDataValue / 100) * 100;
      if (scaleMax < 500) scaleMax = 500;
      const tickCount = 5;
      for (let i = 0; i <= tickCount; i++) {
        let tickValue = Math.round((scaleMax / tickCount) * i);
        let tick = document.createElement('div');
        tick.className = 'y-axis-tick';
        tick.style.bottom = (i * (100 / tickCount)) + '%';
        tick.textContent = tickValue;
        chartWrapper.appendChild(tick);
      }

      data.forEach(d => {
        let bar = document.createElement('div');
        bar.className = 'bar';

        let barFill = document.createElement('div');
        barFill.className = 'bar-fill';
        barFill.style.height = ((d.value / scaleMax) * 100) + '%';
        barFill.style.backgroundColor = d.color;

        let label = document.createElement('div');
        label.className = 'bar-label';
        label.textContent = d.name;

        bar.appendChild(barFill);
        bar.appendChild(label);
        barsContainer.appendChild(bar);
      });
    }
    drawChart(data);
  </script>
</body>

</html>

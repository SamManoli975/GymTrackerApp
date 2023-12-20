<?php
  $host='localhost';
  $dbusername = "root";
  $dbpassword = "";#sam975320
  $dbname = "gym";
  $mysqli = mysqli_connect($host,$dbusername,$dbpassword,$dbname);
  if (!$mysqli) {
    echo "error";
  }else{
    echo"connection made";
  }
  $data1 = '';
  $data2 = '';

  $sql = "select * from dbtest";
  $result = mysqli_query($mysqli,$sql);

  while ($row = mysqli_fetch_array($result)) {
    $data1 = $data1 . '"' . $row['data1'] . '",';
    $data2 = $data2 . '"' . $row['data2'] . '",';
  }

  $data1 = trim($data1,",");
  $data2 = trim($data2,",");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
    <canvas id="chart" width="200" height="200"></canvas>
    <script>
        const ctx = document.getElementById('chart');
      
        new Chart(ctx, {
          type: 'line',
          data: {
            labels: ['june', 'july', 'august', 'september', 'october', 'november','december','jan','feb','march','apr','may','june','july','aug','sept','oct'],
            datasets: [{
              label: 'Data 1',
              data: [<?php echo $data1; ?>],
              borderWidth: 3
            },
            {
              label: 'Data 2',
              data:[<?php echo $data2; ?>],
              borderWidth:3
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      </script>
    
</body>
</html>
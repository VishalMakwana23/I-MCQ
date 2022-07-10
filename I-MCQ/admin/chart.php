<div class="col-xl-6 col-xs-6">
  <div class="card shadow">
     <div class="card-header navbar navbar-inner">
       <header>Student's in Class</header>
       <div class="tools">
          <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
          <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
      </div>
  </div>
  <div class="card-body " id="chartjs_pie_parent">
     <div class="row">
        <canvas id="chartjs_pie" style="height:35vh; width: 100% !important;"></canvas>
    </div>
</div>
</div>
</div>
<?php
$total = mysqli_query($con,"SELECT (select dept from class where id=did) as did FROM `teens` group by did")or die(mysqli_error($con));
$totalstud = mysqli_query($con,"SELECT count(did) as Student FROM `teens` group by did")or die(mysqli_error($con));
?>
<script type="text/javascript">
  $(document).ready(function() {
    var randomScalingFactor = function() {
      return Math.round(Math.random() * 100);
  };

  var config = {
      type: 'pie',
      data: {
        datasets: [{
          data: [
          <?php
          while ($data = mysqli_fetch_assoc($totalstud)) {
            echo "\"".$data['Student']."\",";
        }
        ?>
        ],
        backgroundColor: [
        window.chartColors.red,
        window.chartColors.orange,
        window.chartColors.yellow,
        window.chartColors.green,
        window.chartColors.blue,
        window.chartColors.red,
        ],
        label: 'Dataset 1'
    }],
    labels: [
    <?php
    while ($data = mysqli_fetch_assoc($total)) {
      echo "\"".$data['did']."\",";
  }
  ?>
  ]
},
options: {
 responsive: true,
 legend: {
   position: 'bottom',
},
title: {
   display: true,
   text: 'Pie Chart'
},
animation: {               
    animateRotate: true
}
}
};

var ctx = document.getElementById("chartjs_pie").getContext("2d");
window.myPie = new Chart(ctx, config);
});
</script>
<div class="col-xl-6 col-xs-6">
  <div class="card shadow">
    <div class="card-header navbar navbar-inner">
      <header>Absent Student</header>
      <div class="tools">
        <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
        <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
        <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
    </div>
</div>
<div class="card-body" id="chartjs_doughnut_parent">
  <div class="row">
    <canvas id="chartjs_doughnut" style="height:35vh; width: 100% !important;"></canvas>
</div>
</div>
</div>        
</div>

<?php
$total = mysqli_query($con,"SELECT (select dept from class where id=did) as did FROM `result` where `status`='temp' GROUP by did")or die(mysqli_error($con));
$totalstud = mysqli_query($con,"SELECT count(distinct keyu) as Abs_stud FROM `result` where `status`='temp' GROUP BY did")or die(mysqli_error($con));
?>
<script type="text/javascript">       
  $(document).ready(function() {
    var randomScalingFactor = function() {
      return Math.round(Math.random() * 100);
  };

  var config = {
      type: 'doughnut',
      data: {
        datasets: [{
          data: [
          <?php
          while ($data = mysqli_fetch_assoc($totalstud)) {
            echo "\"".$data['Abs_stud']."\",";
        }
        ?>
        ],
        backgroundColor: [
        window.chartColors.red,
        window.chartColors.orange,
        window.chartColors.yellow,
        window.chartColors.green,
        window.chartColors.blue,
        window.chartColors.red,
        ],
        label: 'Dataset 1'
    }],
    labels: [
    <?php
    while ($data = mysqli_fetch_assoc($total)) {
      echo "\"".$data['did']."\",";
  }
  ?>  
  ]
},
options: {
    responsive: true,
    legend: {
      position: 'bottom',
  },
  title: {
      display: true,
      text: 'Doughnut Chart'
  },
  animation: {
      animateScale: true,
      animateRotate: true
  }
}
};

var ctx = document.getElementById("chartjs_doughnut").getContext("2d");
window.myDoughnut = new Chart(ctx, config);


});
</script>        
<div class="my-4 col-xl-12">
  <div class="card shadow">
    <div class="card-header navbar navbar-inner">
      <header>Student Pass/Fail In Year <?php echo date("Y"); ?></header>
      <div class="tools">
        <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
        <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
    </div>
</div>
<div class="card-body " id="chartjs_bar_parent">
  <div class="row">
    <canvas id="chartjs_bar" style="width: 100% !important;"></canvas>
</div>
</div>
</div>
</div>
<?php
$passstd=1;
$failstd=1;
$did = mysqli_query($con,"SELECT DISTINCT did,(select dept from class where id=did) as dept FROM `result` ")or die(mysqli_error($con));			   
$class = mysqli_query($con,"SELECT * FROM `class`")or die(mysqli_error($con));
while($classdata = mysqli_fetch_assoc($class))
{

   $_COOKIE[$classdata['dept']]['pass'] = array();
   $_COOKIE[$classdata['dept']]['fail'] = array();

   $teen = mysqli_query($con,"SELECT DISTINCT keyu FROM `result` where did='".$classdata['id']."' ORDER BY keyu ASC")or die(mysqli_error($con));
   while ($result = mysqli_fetch_assoc($teen)) {
      $qry = mysqli_query($con,"SELECT * FROM`result` where did='".$classdata['id']."' and keyu='".$result['keyu']."'")or die(mysqli_error($con));
      $pass=0;
      $fail=0;
      $count=1;
      while($qrydata = mysqli_fetch_assoc($qry))
      {
         $sub = mysqli_query($con,"SELECT count(sid) as sid FROM `subject` where did='".$classdata['id']."' and sem='".$qrydata['sem_id']."'")or die(mysqli_error($con));
         $subdata = mysqli_fetch_assoc($sub);
         $no_sub = $subdata['sid'];
         if($qrydata['resultstatus'] == 'Pass')
         {
            $pass++;

        }
        elseif($qrydata['resultstatus'] == 'Fail')
        {
            $fail++;

        }

        if($pass == $no_sub)
        {
         $qry1 = mysqli_query($con,"SELECT * FROM `teens` where keyu='".$result['keyu']."'")or die(mysqli_error($con));
         $data1 = mysqli_fetch_assoc($qry1);
         array_push($_COOKIE[$classdata['dept']]['pass'], $data1['enroll']);
         }
         elseif($count == $no_sub){
          $count=1;
          if ($fail > 0) {
            $qry1 = mysqli_query($con,"SELECT * FROM `teens` where keyu='".$result['keyu']."'")or die(mysqli_error($con));
            $data1 = mysqli_fetch_assoc($qry1);
            array_push($_COOKIE[$classdata['dept']]['fail'], $data1['enroll']);   
            }
        }
$count++;
}
}
}
// echo "<pre>";
// print_r($_COOKIE['FYBSCIT']);
$pass = mysqli_query($con,"SELECT DISTINCT did,(select dept from class where id=did) as dept FROM `result` ")or die(mysqli_error($con));
$fail = mysqli_query($con,"SELECT DISTINCT did,(select dept from class where id=did) as dept FROM `result` ")or die(mysqli_error($con));
?>
<script type="text/javascript">
  $(document).ready(function() {
     var color = Chart.helpers.color;
     var barChartData = {
       labels: [<?php
          while ($data = mysqli_fetch_assoc($did)) {
            if (!empty($_COOKIE[$data['dept']]['fail']) || !empty($_COOKIE[$data['dept']]['pass'])) {
                echo "\"".$data['dept']."\",";
            }
        }
        ?>],
        datasets: [{
         label: ['Fail Students'],
         backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
         borderColor: window.chartColors.red,
         borderWidth: 1,
         data: [
         <?php
         while ($faildata = mysqli_fetch_assoc($fail)) {
            if (!empty($_COOKIE[$faildata['dept']]['fail'])) {
                echo "\"".count($_COOKIE[$faildata['dept']]['fail'])."\",";
            }
    }
    ?>
    ]
}, {
 label: 'Pass Students',
 backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
 borderColor: window.chartColors.blue,
 borderWidth: 1,
 data: [
 <?php
 while ($passdata = mysqli_fetch_assoc($pass)) {
    if (!empty($_COOKIE[$passdata['dept']]['pass'])) {
      echo "\"".count($_COOKIE[$passdata['dept']]['pass'])."\",";
  }
}
?>
]
}]

};

var ctx = document.getElementById("chartjs_bar").getContext("2d");
window.myBar = new Chart(ctx, {
   type: 'bar',
   data: barChartData,
   options: {
      scales:{
         yAxes:[{
            ticks:{
              min:0,
										//stepSize:1,
                                  }
                              }]
                          },
                          responsive: true,
                          legend: {
                             position: 'bottom',
                         },
                         title: {
                             display: true,
                             text: 'Bar Chart'
                         }
                     }
                 });

});

</script>

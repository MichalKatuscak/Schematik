<?php

$level = 2;
$koe = 2;
$s = 100;

if (isset($_GET["level"])) {
    $level = $_GET["level"];
}

if (isset($_GET["koe"])) {
    $koe = $_GET["koe"];
}
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Schematické myšlení</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <style>
    @media screen and (min-width:768px) {
        .skin-blue .main-header .logo,
        .main-sidebar, .left-side {
            width: 300px;
        }

        .content-wrapper, .right-side, .main-footer {
            margin-left: 300px;
        }
    }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Schematické</b> myšlení</span>
    </a>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="color:#fff;padding:0 15px;">
        <p class="text-center">
            <br/>
        <button onclick="location.reload()" class="btn btn-success">Generovat nové schéma</button>
        </p>
        <h3>Pravidla:</h3>
        <ol style="padding-left: 15px">
            <li>Schéma se čte buď jako <b>řádek</b> zleva doprava nebo jako <b>sloupec</b> zhora dolů</li>
            <li>Každý ze znaků zastupuje jeden z těchoto úkonů</li>
            <ul>
                <li>invertuje barvy</li>
                <li>zmenší</li>
                <li>zvětší</li>
                <li>přidá horizontální linku</li>
                <li>přidá vertikální linku</li>
                <li>otočí o 90 stupňu</li>
                <li>změní tvar</li>
            </ul>
            <li>Otočení se vztahuje i na linky přidané do objektu dříve či později.</li>
            <li>Zmenšení a zvětšení se nekumuluje, ale může se vzájemně vyrušit.</li>
        </ol>
        <h3>Level:</h3>
        <select class="form-control" onchange="location.href='?level='+this.value">
            <?php
            for($i=1;$i<5;$i++){
                echo "<option ".($level==$i?"selected":"").">$i</option>";
            }
            ?>
        </select>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Test
        <small>Verze 0.1</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-5">
          <!-- MAP & BOX PANE -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Graf</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                

                
                
                

            
<?php
                
$starts = [];
$ends = [];
$lines_vertical = [];
$lines_horizontal = [];

$size = [$level, $level];

foreach($size as $x_or_y=>$value) {
    $count = 0;
    while($level > $count) {
        $one_point = rand(1, $size[$x_or_y]);
        $max_point = $size[(int)!$x_or_y]+1;

        if ($x_or_y) { // X
            $start = [$one_point, 0];
            $end = [$one_point, $max_point];
        } else { // Y
            $start = [0, $one_point];
            $end = [$max_point, $one_point];
        }

        if (!in_array($start, $starts)) {
            $starts[] = $start;
            $ends[] = $end;

            if ($x_or_y) {
                $lines_horizontal[] = [$start, $end];
            } else {
                $lines_vertical[] = [$start, $end];
            }
            $count++;
        }
    }
}

$lines = array_merge($lines_vertical, $lines_horizontal);
$points = [];
$functions = [
    "line_horizontal","line_vertical","inversion_color","step_geo","rotate90","scale_up","scale_down"
];
$zastup = [
    "#","\$","@","&","~","*","%" // ,"^"
];
$geo = [
    "kruh","ctverec","trojuhelnik"
    //,"hvezda","sestiuhelnik"
];

shuffle($zastup);
shuffle($functions);
shuffle($geo);
        
$schema = [];
        
foreach ($lines_horizontal as $line_horizontal) {
    foreach ($lines_vertical as $line_vertical) {
        $test = rand(0,count($functions)-1);
        $points[] = [$line_horizontal[0][0],$line_vertical[1][1],$test];
        $schema[$line_horizontal[0][0]."_".$line_vertical[1][1]] = $test;
    }
}

//$im  = imagecreate ($size[0]*$s+300, $size[1]*$s+300); 
//$w   = imagecolorallocate ($im, 255, 255, 255); 
//$color = imagecolorallocate ($im, 0, 0, 0); 


echo '<svg viewBox="0 0 '.((1+$size[1])*$s+45).' '.((1+$size[0])*$s+45).'" style="width:100%;height:auto">';
foreach ($lines as $key=>$line) {
    $x1 = $line[0][0]+0.16;
    $x2 = $line[1][0]+0.16;
    $y1 = $line[0][1]+0.16;
    $y2 = $line[1][1]+0.16;
    
    $value = [
        "geo" => rand(0,count($geo)-1)
    ];
    $value_on_start = $value;
    if ($x1 == $x2) { // X
        $use = 0;
    } else { // Y
        $use = 1;
    }
    for($i=1;$i<=$size[(int)!$use];$i++) {
        
        if (!$use) {
            $is_exists = $line[0][0]."_".$i;
        } else {
            $is_exists = $i."_".$line[1][1];
        }
        if (isset($schema[$is_exists])) {
            $funtion = $functions[$schema[$is_exists]];
            @$funtion($value);
        }
    }
    //imagestring ($im, 5 , $x1*$s+10 , $y1*$s+10 , $key , $color );
    //imagestring ($im, 5 , $x2*$s+10 , $y2*$s+10 , $value , $color );
    //imageline ($im, $x1*$s, $y1*$s, $x2*$s, $y2*$s, $color);
    
    echo '<line x1="'.( $x1 * $s ).'" y1="'.($y1 * $s).'" x2="'.($x2 * $s).'" y2="'.($y2 * $s).'" style="stroke:#367fa9;stroke-width:2" />';
    
    $render = "render_".$geo[$value_on_start["geo"]];
    if (function_exists($render)) echo $render($value_on_start, $x1*$s, $y1*$s);

    $render = "render_".$geo[$value["geo"]];print_r($value);
    if (function_exists($render)) echo $render($value, $x2*$s, $y2*$s);
    
    if ($use) {
        //echo '<rect  x="'.($x1*$s+1).'" y="'.($y1*$s-15).'" width="30" height="30" style="fill:white;stroke-width:2;stroke:#367fa9" />';
        //echo '<text text-anchor="middle" x="'.($x1*$s+15).'" y="'.($y1*$s+5).'" fill="#367fa9">'.$key.'</text>';
        
    echo '<polyline fill="none" stroke="#367fa9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="
	'.($x1*$s+55).','.($y1*$s-10).' '.($x1*$s+70).','.($y1*$s).' '.($x1*$s+55).','.($y1*$s+10).'"/>';
        
    echo '<polyline fill="none" stroke="#367fa9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="
	'.($x2*$s-60).','.($y2*$s-10).' '.($x2*$s-45).','.($y2*$s).' '.($x2*$s-60).','.($y2*$s+10).'"/>';
        
        //echo '<rect  x="'.($x2*$s-15).'" y="'.($y2*$s+1-15).'" width="30" height="30" style="fill:white;stroke-width:2;stroke:#367fa9" />';
        //echo '<text text-anchor="middle" x="'.($x2*$s).'" y="'.($y2*$s+6).'" fill="#367fa9">'.$value.'</text>';
    } else {
        //echo '<rect  x="'.($x1*$s-15).'" y="'.($y1*$s+1).'" width="30" height="30" style="fill:white;stroke-width:2;stroke:#367fa9" />';
        //echo '<text text-anchor="middle" x="'.($x1*$s).'" y="'.($y1*$s+20).'" fill="#367fa9">'.$key.'</text>';
        
    echo '<polyline fill="none" stroke="#367fa9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="
	'.($x1*$s-10).','.($y1*$s+55).' '.($x1*$s).','.($y1*$s+70).' '.($x1*$s+10).','.($y1*$s+55).'"/>';
        
    echo '<polyline fill="none" stroke="#367fa9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="
	'.($x2*$s-10).','.($y2*$s-60).' '.($x2*$s).','.($y2*$s-45).' '.($x2*$s+10).','.($y2*$s-60).'"/>';
    
        //echo '<rect  x="'.($x2*$s-15).'" y="'.($y2*$s+1-15).'" width="30" height="30" style="fill:white;stroke-width:2;stroke:#367fa9" />';
        //echo '<text text-anchor="middle" x="'.($x2*$s).'" y="'.($y2*$s+6).'" fill="#367fa9">'.$value.'</text>';
    }
}

foreach ($points as $key=>$point) {
    //imagestring ($im, 5 , $point[0]*$s+5 , $point[1]*$s+15 , $zastup[$point[2]] , $color );
    echo '<circle cx="'.($point[0]*$s+15).'" cy="'.($point[1]*$s+15).'" r="15" stroke="#367fa9" stroke-width="2" fill="white" />';
    echo '<text text-anchor="middle" x="'.($point[0]*$s+15).'" y="'.($point[1]*$s+20).'" fill="#367fa9">'.$zastup[$point[2]].'</text>';
}

echo "</svg>";
?>

      
                
                
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
        <div class="col-md-4">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Ověření výsledků</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
          
                
                
                
                
<?php
echo "<table class='table table-bordered'>";
foreach ($zastup as $i=>$znak) {
    echo "<tr>";
    echo "<td align=center valign=middle style='vertical-align:middle'><b>$znak</b></td>";
    //imagestring ($im, 5 , 10 , $size[1]*140+(16*$i), $znak ." = ".$functions[$i]." $koe", $color );
    echo "<td><select class='form-control control' data-value='$i'><option>--- zvolte ---</option>";
    foreach ($functions as $k=>$f) {
        echo "<option value='$k'>$f</option>";
    }
    echo "</select></td>";
    
    echo "</tr>";
}
echo "</table>";

echo "<br/><p class='text-center'><button class='btn btn-primary zkontrolovat'>Zkontrolovat</button></p>";

//header("content-type:image/png");
//echo imagepng($im);

function plus($i) {global $koe; return $i+$koe;}
function minus($i) {global $koe;return $i-$koe;}
function krat($i) {global $koe;return $i*$koe;}
function lomeno($i) {global $koe;return $i/$koe;}
        
function render_trojuhelnik($data, $x, $y) {
    $color1 = "#367fa9";
    $color2 = "white";
    
    if (!empty($data["inversion_color"])) {
        $tmp = $color1;
        $color1 = $color2;
        $color2 = $tmp;
    }
    
    $style = "fill:$color2;stroke-width:2;stroke:#367fa9;transform: ";
    if (!empty($data["rotate"])) {
        $style .= 'rotate('.$data["rotate"].'deg) ';
    }
    if (@$data["scale"] != 0) {
        $scale = 1.5;
        if ($data["scale"] == -1) {
            $scale = 0.5;
        }
        $style .= 'scale('.$scale.') ';
    }
    $style .= ";transform-origin: 50% 50%;";
    
    $rect = '<polygon  stroke-linecap="round" stroke-linejoin="round" points="'.($x-15).','.($y+15).' '.($x+15).','.($y+15).' '.($x).','.($y-15).'" style="'.$style.'" />';
    if (!empty($data["line_horizontal"])) {
        $rect .= render_line_horizontal($data,$x,$y,$color1, $color2,16);
    }
    if (!empty($data["line_vertical"])) {
        $rect .= render_line_vertical($data,$x,$y,$color1, $color2);
    }
    return $rect;
}
        
function render_ctverec($data, $x, $y) {
    $color1 = "#367fa9";
    $color2 = "white";
    
    if (!empty($data["inversion_color"])) {
        $tmp = $color1;
        $color1 = $color2;
        $color2 = $tmp;
    }
    
    $style = "fill:$color2;stroke-width:2;stroke:#367fa9;transform: ";
    if (!empty($data["rotate"])) {
        $style .= 'rotate('.$data["rotate"].'deg) ';
    }
    if (@$data["scale"] != 0) {
        $scale = 1.5;
        if ($data["scale"] == -1) {
            $scale = 0.5;
        }
        $style .= 'scale('.$scale.') ';
    }
    $style .= ";transform-origin: 50% 50%;";
    
    $rect = '<rect  x="'.($x-15).'" y="'.($y-15).'" width="30" height="30" style="'.$style.'"/>';
    if (!empty($data["line_horizontal"])) {
        $rect .= render_line_horizontal($data,$x,$y,$color1, $color2);
    }
    if (!empty($data["line_vertical"])) {
        $rect .= render_line_vertical($data,$x,$y,$color1, $color2);
    }
    return $rect;
}
          
function render_kruh($data, $x, $y) {
    $color1 = "#367fa9";
    $color2 = "white";
    
    if (!empty($data["inversion_color"])) {
        $tmp = $color1;
        $color1 = $color2;
        $color2 = $tmp;
    }
    
    $style = "fill:$color2;stroke-width:2;stroke:#367fa9;transform: ";
    if (!empty($data["rotate"])) {
        $style .= 'rotate('.$data["rotate"].'deg) ';
    }
    if (@$data["scale"] != 0) {
        $scale = 1.5;
        if ($data["scale"] == -1) {
            $scale = 0.5;
        }
        $style .= 'scale('.$scale.') ';
    }
    $style .= ";transform-origin: 50% 50%;";
        
    $circle = '<circle  cx="'.($x).'" cy="'.($y).'" r="15"  style="'.$style.'" />';
    if (!empty($data["line_horizontal"])) {
        $circle .= render_line_horizontal($data,$x,$y,$color1, $color2);
    }
    if (!empty($data["line_vertical"])) {
        $circle .= render_line_vertical($data,$x,$y,$color1, $color2);
    }
    return $circle;
}
        
function render_line_horizontal($data,$x,$y,$color1, $color2,$width=30) {
    $rotate = 0;
    if (!empty($data["rotate"])) {
        $rotate += $data["rotate"];
    }
    $scale = 1;
    if (@$data["scale"] != 0) {
        $scale = 1.5;
        if ($data["scale"] == -1) {
            $scale = 0.5;
        }
    }
    return '<line stroke-linecap="round" stroke-linejoin="round" x1="'.($x+($width/2-1)).'" y1="'.($y).'" x2="'.($x-($width/2-1)).'" y2="'.($y).'" style="transform: rotate('.$rotate.'deg) scale('.$scale.');transform-origin: 50% 50%;stroke:'.$color1.';stroke-width:2" />';
}
        
function render_line_vertical($data,$x,$y,$color1, $color2) {
    $rotate = 90;
    if (!empty($data["rotate"])) {
        $rotate += $data["rotate"];
    }
    $scale = 1;
    if (@$data["scale"] != 0) {
        $scale = 1.5;
        if ($data["scale"] == -1) {
            $scale = 0.5;
        }
    }
    return '<line stroke-linecap="round" stroke-linejoin="round" x1="'.($x+14).'" y1="'.($y).'" x2="'.($x-14).'" y2="'.($y).'" style="transform: rotate('.$rotate.'deg) scale('.$scale.');transform-origin: 50% 50%;stroke:'.$color1.';stroke-width:2" />';
}
        
function line_horizontal(&$data){
    $data["line_horizontal"] = true;
}
function line_vertical(&$data){
    $data["line_vertical"] = true;
}
function inversion_color(&$data){
    if ($data["inversion_color"]) {
        $data["inversion_color"] = false;
    } else {
        $data["inversion_color"] = true;
    }
}
function step_geo(&$data){
    global $geo;
    $data["geo"]++;
    if ($data["geo"] >= count($geo)) {
        $data["geo"] = 0;
    }
}
function rotate90(&$data){
    $data["rotate"] += 90;
}
function scale_up(&$data){
    if ($data["scale"] == -1) {
        $data["scale"] = 0;
    } else {
        $data["scale"] = 1;
    }
}
function scale_down(&$data){
    if ($data["scale"] == 1) {
        $data["scale"] = 0;
    } else {
        $data["scale"] = -1;
    }
}

/*
echo "<pre>";
            
echo "straight\n";
print_r($straight_lines);
echo "onebreak\n";
print_r($onebreak_lines);
echo "starts\n";
print_r($starts);
echo "ends\n";
print_r($ends);
*/
?>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
$(".zkontrolovat").on("click", function(){
    $("select.control").each(function(){
        if ($(this).val() == $(this).data("value")) {
            $(this).closest("tr").children("td").css("background","#00a65a");
        } else {
            $(this).closest("tr").children("td").css("background","#dd4b39");
        }
    });
});
</script>              
                
                
                
                
                
                
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
          
          
          
            <div class="col-md-3">
              <!-- DIRECT CHAT -->
              <div class="box box-warning direct-chat direct-chat-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Seznam úprav</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <!-- Conversations are loaded here -->
                  <div class="direct-chat-messages">
                    <!-- Message. Default to the left -->
                    <div class="direct-chat-msg">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">Michal Katuščák</span>
                        <span class="direct-chat-timestamp pull-right">20. října 2016</span>
                      </div>
                      <!-- /.direct-chat-info -->
                      <img class="direct-chat-img" src="https://secure.gravatar.com/avatar/294f7db71b6dcc815b5fe1cb47e551b5?s=64&d=mm&r=pg" alt="message user image"><!-- /.direct-chat-img -->
                      <div class="direct-chat-text">
                        Zprovozněnil jsem ověření odpovědí a taky nový design (AdminLTE šablona).
                      </div>
                      <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->
                      
                    <!-- Message. Default to the left -->
                    <div class="direct-chat-msg">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">Michal Katuščák</span>
                        <span class="direct-chat-timestamp pull-right">19. října 2016</span>
                      </div>
                      <!-- /.direct-chat-info -->
                      <img class="direct-chat-img" src="https://secure.gravatar.com/avatar/294f7db71b6dcc815b5fe1cb47e551b5?s=64&d=mm&r=pg" alt="message user image"><!-- /.direct-chat-img -->
                      <div class="direct-chat-text">
                        Přetvořil jsem číselnou logiku na grafickou.
                      </div>
                      <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->

                  </div>
                  <!--/.direct-chat-messages-->

                </div>
                <!-- /.box-body -->
              </div>
              <!--/.direct-chat -->
            </div>
            <!-- /.col -->
          
          
          
          
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>:)</b>
    </div>
    <strong>&copy; 2016 <a href="http://www.katuscak.cz">Michal Katuščák</a>.</strong> Všechna práva vyhrazena
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
    
</body>
</html>

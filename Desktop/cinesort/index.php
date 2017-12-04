<?php
  include 'connect.php';
  session_start();
  if (isset($_GET['logout'])) {
		session_destroy();
    header("location: index.php");
  }

 ?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name = "viewport" content = "width = device-width">
    <title>Cinesort</title>
     <link rel = "stylesheet" href = "./css/style.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
     <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
     <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
     <link rel="stylesheet" href="/resources/demos/style.css">

    </head>


    <?php
        if (isset($_REQUEST['scorefilter']))
        {
          list($min, $max) = explode (" - ", $_REQUEST['scorefilter'][0]);
          $min1 = (int)$min;
          $max1 = (int) $max;
        }
        else {
          $min1 = 50;
          $max1 = 100;
        }

        $sql = "SELECT MIN(date) FROM movies";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $temp1 = (int)$row['MIN(date)'];

        $sql = "SELECT MAX(date) FROM movies";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $temp2 = (int)$row['MAX(date)'];

        if (isset($_REQUEST['yearfilter']))
        {
          list($min, $max) = explode (" - ", $_REQUEST['yearfilter'][0]);
          $miny = (int)$min;
          $maxy = (int)$max;
        }
        else {
          $miny = $temp1;
          $maxy = $temp2;
        }

        $sql = "SELECT MIN(runtime) FROM movies";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $minRuntime = (int)$row['MIN(runtime)'];

        $sql = "SELECT MAX(runtime) FROM movies";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $maxRuntime = (int)$row['MAX(runtime)'];

        if (isset($_REQUEST['runtimefilter']))
        {
          list($min, $max) = explode (" - ", $_REQUEST['runtimefilter'][0]);
          $minr = (int)$min;
          $maxr = (int)$max;
        }
        else {
          $minr = $minRuntime;
          $maxr = $maxRuntime;
        }

     ?>

    <script>
    $( function() {
      var min1 = <?php echo json_encode($min1); ?>;
      var max1 = <?php echo json_encode($max1); ?>;

      $( "#slider-range" ).slider({
        range: true,
        min: 50,
        max: 100,
        values: [ min1, max1 ],
        slide: function( event, ui ) {
          $( "#amount" ).val(ui.values[ 0 ] + " - " + ui.values[ 1 ] );
        }
      });
      $( "#amount" ).val($( "#slider-range" ).slider( "values", 0 ) +
        " - " + $( "#slider-range" ).slider( "values", 1 ) );
    } );
    </script>

    <script>
    $( function() {
      var miny1 = <?php echo json_encode($temp1); ?>;
      var maxy1 = <?php echo json_encode($temp2); ?>;
      var miny2 = <?php echo json_encode($miny); ?>;
      var maxy2 = <?php echo json_encode($maxy); ?>;
      $( "#slider-range2" ).slider({
        range: true,
        min: miny1,
        max: maxy1,
        values: [ miny2, maxy2 ],
        slide: function( event, ui ) {
          $( "#amount2" ).val(ui.values[ 0 ] + " - " + ui.values[ 1 ] );
        }
      });
      $( "#amount2" ).val($( "#slider-range2" ).slider( "values", 0 ) +
        " - " + $( "#slider-range2" ).slider( "values", 1 ) );
    } );
    </script>

    <script>
    $( function() {
      var minr1 = <?php echo json_encode($minRuntime); ?>;
      var maxr1 = <?php echo json_encode($maxRuntime); ?>;
      var minr2 = <?php echo json_encode($minr); ?>;
      var maxr2 = <?php echo json_encode($maxr); ?>;
      $( "#slider-range3" ).slider({
        range: true,
        min: minr1,
        max: maxr1,
        values: [ minr2, maxr2 ],
        slide: function( event, ui ) {
          $( "#amount3" ).val(ui.values[ 0 ] + " - " + ui.values[ 1 ]);
        }
      });
      $( "#amount3" ).val($( "#slider-range3" ).slider( "values", 0 ) +
        " - " + $( "#slider-range3" ).slider( "values", 1 ) );
    } );
    </script>

<body>
    <header>
      <center><a href = "index.php"><img src="img/logo.png" height = "60"></a></center>
      <div id = "sidebar" >
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="#">Watchlist</a></li>
          <?php
            if (ISSET($_SESSION["username"])):?>
                <li><a href = "index.php?logout='1'">Log out</a></p>
            <?php else: ?>
                <li><a href="/cinesort/registration/login.php">Log In</a></li>
              <?php endif?>

        </ul>
        <div id = "sidebar-btn">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <script>
      $(document).ready(function(){
        $('#sidebar-btn').click(function(){
          $('#sidebar').toggleClass('visible');
        });
      });
      </script>
    </header>

    <form action = "" method = "GET">
      <input type = "text" name = "search" placeholder = "Search" value = "<? echo isset($_REQUEST['search']) ? $_REQUEST['search'] : ""?>"></input>

<div id = "filterbox">
    <b id = "expandfilter">Filters</b>
    <div id = "genrefilter">

  <script method = "post" type="text/javascript">
      var myValues;
      $(function() {
          $(".chzn-select").chosen({width: '40%'});

      });
      </script>
      Genres:
      <select name = "genres[]" class="chzn-select" multiple="multiple">
        <?php
        $sql = "SELECT DISTINCT genre FROM movies ORDER BY genre ASC";
        $result = $db->query($sql);
        while($row = $result->fetch_assoc()): ?>
              <option value = "<? echo $row['genre']?>"<? echo isset($_REQUEST['genres']) && in_array($row['genre'], $_REQUEST['genres']) ? "selected" : '';?>><? echo $row['genre'] ?></option>
            <?php endwhile; ?>

      </select>
    </div>

    <div id = "slider-parent">
      Score:
    <div id="slider-range"></div>
    <input name = "scorefilter[]" type="text" id="amount">
</div>

<div id = "slider-parent2">
  Year:
<div id="slider-range2"></div>
<input name = "yearfilter[]" type="text" id="amount2">
</div>

<div id = "slider-parent3">
  Runtime:
<div id="slider-range3"></div>
<input name = "runtimefilter[]" type="text" id="amount3">
</div>

    </div>

<input id = "searchButton" type="submit"  value="Search"/>

<script>
$(document).ready(function(){
  $('#expandfilter').click(function(){
    $('#filterbox').toggleClass('visible');
    $('#genrefilter').toggleClass('visible');
    $('#searchButton').toggleClass('visible');
    $('#slider-range').toggleClass('visible');
    $('#amount').toggleClass('visible');
    $('#slider-parent').toggleClass('visible');
    $('#slider-range2').toggleClass('visible');
    $('#amount2').toggleClass('visible');
    $('#slider-parent2').toggleClass('visible');
    $('#slider-range3').toggleClass('visible');
    $('#amount3').toggleClass('visible');
    $('#slider-parent3').toggleClass('visible');

  });
});
</script>

<div id = "sort">
<select name = "sortby">
  <option value = "score DESC" selected = "selected">Sort By:</option>
  <option value = "score ASC">Score (Ascending) </option>
  <option value = "date ASC" >Year (Ascending) </option>
  <option value = "runtime ASC">Runtime (Ascending) </option>
  <option value = "score DESC">Score (Descending) </option>
  <option value = "date DESC" >Year (Descending) </option>
  <option value = "runtime DESC">Runtime (Descending) </option>
</select>
  <input class="SubmitButton" type="submit"  value="Submit"/>
</div>
</form>


<?php
$sql = "SELECT * FROM movies";

if(isset($_REQUEST['search']) && !empty($_REQUEST['search']))
{
  $search = mysqli_real_escape_string($db, $_REQUEST['search']);
}
else {
  $search = mysqli_real_escape_string($db, '');
}

$sql .= " WHERE title LIKE '%$search%'";

if (isset($_REQUEST['genres'])){
  for ($i = 0; $i < count($_REQUEST['genres']); $i++) {
       $post = $_REQUEST['genres'][$i];
       if ($i == 0) {
           $sql .= " AND genre = '" . mysqli_real_escape_string($db, $post) . "'";

       } else {
            $sql .= " OR genre = '" . mysqli_real_escape_string($db, $post) . "'";
       }
   }
 }

 if (isset($_REQUEST['scorefilter']))
 {
   list($min, $max) = explode (" - ", $_REQUEST['scorefilter'][0]);
 }
else {
  $min = 50;
  $max = 100;
}

$sql .= " AND score >= $min AND score <= $max";

if (isset($_REQUEST['yearfilter']))
{
  list($min, $max) = explode (" - ", $_REQUEST['yearfilter'][0]);
}
else {
  $min = $temp1;
  $max = $temp2;
}

$sql .= " AND date >= $min AND date <= $max";

if (isset($_REQUEST['runtimefilter']))
{
  list($min, $max) = explode (" - ", $_REQUEST['runtimefilter'][0]);
}
else {
  $min = $minr;
  $max = $maxr;
}

$sql .= " AND runtime >= $min AND runtime <= $max";

if (isset($_REQUEST['sortby'])){
  $order = $_REQUEST['sortby'];
}else {
  $order = 'score DESC';
}
$sql .=" ORDER BY $order";
$result = $db->query($sql);

while($row = $result->fetch_assoc()): ?>
<div class = "movie">
  <div class = "metascore">
    <?= $row['score']?>
  </div>
    <h1><?= $row['title']. " (". $row['date'].")"?></h1>
    <i><? echo $row['genre']. "<br>"?></i>
    <? echo $row['rating']. "<br>"?>
    <? echo $row['runtime']. " min<br>"?>
</div>
<?php endwhile; ?>




  </body>
</html>

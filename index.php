<?php

include('config/config.php');
session_start();

if (isset($_GET['type']) && $_GET['type']=='delete') 
{
    $id=mysqli_real_escape_string($con,$_GET['id']);
    mysqli_query($con,"DELETE FROM todos WHERE `todos`.`id` = '$id'"); 
    header('location:/'); 
};

if (isset($_GET['type']) && $_GET['type']=='status') 
{
    $id=mysqli_real_escape_string($con,$_GET['id']);
    $status=mysqli_real_escape_string($con,$_GET['status']);
    if ($status=='checked') {
        $sqlRun1="UPDATE `todos` SET `checked` = '1' WHERE `todos`.`id` = '$id'";
        mysqli_query($con,$sqlRun1);
        header('location:/'); 
    } else {
        $sqlRun1="UPDATE `todos` SET `checked` = '0' WHERE `todos`.`id` = '$id'";
        mysqli_query($con,$sqlRun1);
        header('location:/'); 
    }
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Todo App</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
  <div class="container mx-auto px-4 mt-12">
    <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
      <h1 class="text-2xl font-semibold text-gray-800">Todo App</h1>
    </div>
    <div class="bg-white rounded-lg shadow-lg p-4 rounded-b-lg">
        <div class="flex items-center justify-between pb-4">
            <?php 
             
             if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
                unset($_SESSION['status']);
            
            ?>
            <div class="relative w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none border-2 border-red-500 rounded-lg">
            <?php 
             
            } else {
                unset($_SESSION['success']);
            ?>
            <div class="relative w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none border-2 border-gray-300 rounded-lg">
            
            <?php }?>

            <form action="app/add.php" method="POST" autocomplete="off">
                <input class="appearance-none w-full py-2 pr-12 text-gray-700 leading-tight focus:outline-none" type="text" name="title" placeholder="Enter a new Task">
                <button  type="submit" class="absolute right-0 top-0 mt-2 mr-2 bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-full">
                  <i class="fa fa-arrow-right"></i>
                </button>
              </form>
            </div>
        </div>
      <div class="flex flex-col">

      <?php

          $querytask=mysqli_query($con, "SELECT * FROM `todos` ORDER BY `todos`.`id` DESC");
          while($row=mysqli_fetch_assoc($querytask)){

            $timeDiff = (time()-$row['time']);
            if ($timeDiff<15) {
              $timeStat = "Just Now";
            } elseif ($timeDiff<60) {
              $timeStat = $timeDiff." Seconds Ago";
            } elseif ($timeDiff<(60*60)) {
              $timeStat = floor(($timeDiff/60))." Minutes Ago";
            } elseif ($timeDiff<(60*60*24)) {
              $timeStat = floor(($timeDiff/(60*60)))." Hours Ago";
            } elseif ($timeDiff<(60*60*24*7)) {
              $timeStat = floor(($timeDiff/(60*60*24)))." Days Ago";
            } else {
              $timeStat = floor(($timeDiff/(60*60*24*7)))." Weeks Ago";
            }
            

      ?>         
          <div class="p-2 bg-gray-200 rounded-lg flex items-center my-3">
          <?php if ($row['checked']==0) { ?>
              <a href="?id=<?php echo $row['id'] ?>&type=status&status=checked" class="text-blue-700 font-semibold"><i class="fa fa-square" aria-hidden="true"></i></a>
              <p class="ml-4 text-gray-800 font-semibold"><?php echo $row['title'] ?></p>
          <?php } else { ?>
              <a href="?id=<?php echo $row['id'] ?>&type=status&status=unchecked" class="text-blue-800 font-semibold"><i class="fa fa-check-square" aria-hidden="true"></i></a>
              <p class="ml-4 text-gray-500 font-semibold line-through"><?php echo $row['title'] ?></p>
          <?php } ?>
          
            
              <div class="ml-auto flex items-center">
                <p class="text-gray-600 text-xs mr-2 whitespace-nowrap"><?php echo $timeStat ?></p>
                <a href="?id=<?php echo $row['id'] ?>&type=delete">
                  <button class="bg-gray-200 hover:bg-grey-500 text-gray font-bold py-2 px-2">
                    <i class="fa fa-times"></i>
                  </button>
                </a>
              </div>
          </div>

          <?php } ?>

      </div>
    </div>
  </div>
  
  
  <br> <br> <br>
    <footer class="bg-gray-100 py-4 text-center text-gray-800">
      <p class="mb-0">
        &copy; Fahad Dhruba | <a href="https://github.com/fahaddhruba" class="text-gray-700 hover:text-gray-600">GitHub</a>
      </p>
    </footer>

 
</body>
</html>

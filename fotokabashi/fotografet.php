
<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php"); 
error_reporting(0);
session_start();

include_once 'product-action.php'; 

?>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>FotoKabashi</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
 
    <header id="header" class="header-scroll top-header headrom">
        <nav class="navbar navbar-dark">
            <div class="container">
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/logo.png" width="90px" alt=""></a>
                <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"> <a class="nav-link active" href="index.php">Ballina <span class="sr-only">(current)</span></a> </li>
                        <?php
						if(empty($_SESSION["user_id"]))
							{
								echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
							  <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
							}
						else
							{
										echo  '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a> </li>';
									echo  '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
							}

						?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="page-wrapper">
        
        
    <section class="hero">
   <style>
        .hero {
            background-image: url('images/bg2.jfif');
            background-position: center top -240px;
        }
    </style>
        <div class="hero-inner">
            <div class="container text-center hero-text font-white">
                <h1>FotoKabashi </h1>
                <div class="banner-form">
                    <form class="form-inline">
                    </form>
                </div>
            </div>
        </div>
    </section>
        <div class="breadcrumb">
            <div class="container">
            </div>
        </div>
        <div class="container m-t-30">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">

                    <div class="widget widget-cart">
                        <div class="widget-heading">
                            <h3 class="widget-title text-dark">
                                Karta juaj
                            </h3>

                            <div class="clearfix"></div>
                        </div>
                        <div class="order-row bg-white">
                            <div class="widget-body">
                                <?php

$item_total = 0;

foreach ($_SESSION["cart_item"] as $item)  
{
?>

                                <div class="title-row">
                                    <?php echo $item["title"]; ?><a href="fotografet.php?res_id=<?php echo $_GET['res_id']; ?>&action=remove&id=<?php echo $item["d_id"]; ?>">
                                        <i class="fa fa-trash pull-right"></i></a>
                                </div>

                                <div class="form-group row no-gutter">
                                    <div class="col-xs-8">
                                        <input type="text" class="form-control b-r-0" value=<?php echo "$".$item["price"]; ?> readonly id="exampleSelect1">
                                    </div>
                                </div>

                                <?php
$item_total += ($item["price"]*$item["quantity"]); 
}
?>
                            </div>
                        </div>
                        <div class="widget-body">
                            <div class="price-wrap text-xs-center">
                                <p>TOTAL</p>
                                <h3 class="value"><strong><?php echo "€".$item_total; ?></strong></h3>
                                <?php
                                        if($item_total==0){
                                        ?>


                                <a href="checkout.php?res_id=<?php echo $_GET['res_id'];?>&action=check" class="btn btn-danger btn-lg disabled">Rezervo</a>

                                <?php
                                        }
                                        else{   
                                        ?>
                                <a href="checkout.php?res_id=<?php echo $_GET['res_id'];?>&action=check" class="btn btn-success btn-lg active">Rezervo</a>
                                <?php   
                                        }
                                        ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">


                <div class="menu-widget" id="<?php echo $_GET['res_id']; ?>">
    <div class="widget-heading">
        <h3 class="widget-title text-dark">
            <a class="btn btn-link pull-right" data-toggle="collapse" href="#popular2" aria-expanded="true">
                <i class="fa fa-angle-right pull-right"></i>
                <i class="fa fa-angle-down pull-right"></i>
            </a>
        </h3>
        <div class="clearfix"></div>
    </div>
    <div class="collapse in" id="popular2">
        <?php   
        $stmt = $db->prepare("SELECT * FROM fotografet WHERE d_id = ?");
        $stmt->bind_param("i", $_GET['d_id']);
        $stmt->execute();
        $products = $stmt->get_result();
        if (!empty($products)) {
            foreach ($products as $product) {
        ?>
       
      
                <div class="food-item">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-lg-8">
                            <form method="post" action="fotografet.php?res_id=<?php echo $_GET['res_id']; ?>&action=add&id=<?php echo $product['d_id']; ?>">
                                <div class="rest-logo pull-left">
                                    <a class="restaurant-logo pull-left" href="#"><?php echo '<img src="admin/Res_img/dishes/' . $product['img'] . '" alt="Food logo">'; ?></a>
                                </div>
                                <div class="rest-descr">
                                    <h6><a href="#"><?php echo $product['title']; ?></a></h6>
                                    <p><?php echo $product['slogan']; ?></p>
                                </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-lg-3 pull-right item-cart-info">
                            <span class="price pull-left">$<?php echo $product['price']; ?></span>
                            <input type="submit" class="btn theme-btn" style="margin-left:40px;" value="Shto ne Shport" />

                        </div>
                    </form>
                    

                    </div>
                </div>
        <?php
            }
        }
        ?>
        <style>
    .rating {
        display: inline-block;
        transform: scaleX(-1);

    }

    .rating input {
        display: none;
    }

    .rating label {
        font-size: 30px;
        color: #ddd;
        cursor: pointer;
    }

    .rating label:before {
        content: '\2605'; 
    }

    .rating input:checked ~ label {
        color: #ffcc00; 
    }
</style>
                            <form action="" method="post">
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label for="exampleInputEmail1">Comment</label>
                                                <input class="form-control" type="text" name="comment" id="example-text-input">
                                                <div class="form-group col-sm-12">
                                                <label for="exampleInputRating">Rating</label>
                                                <div class="rating">
                                                    <input type="radio" id="star1" name="rating" value="1">
                                                    <label for="star1" title="1 stars"></label>
                                                    <input type="radio" id="star2" name="rating" value="2">
                                                    <label for="star2" title="2 stars"></label>
                                                    <input type="radio" id="star3" name="rating" value="3">
                                                    <label for="star3" title="3 stars"></label>
                                                    <input type="radio" id="star4" name="rating" value="4">
                                                    <label for="star4" title="2 stars"></label>
                                                    <input type="radio" id="star5" name="rating" value="5">
                                                    <label for="star5" title="5 star"></label>
                                                </div>
                                                <p> <input type="submit" value="Shto Komentin" name="submit" class="btn theme-btn"> </p>

                                            </div>
                                            
                                            </div>
                            </form>
     <?php

if(isset($_POST['submit'] )) 
{
     if(empty($_POST['comment']))
   	    
		{
            echo "<script>alert('Komenti nuk duhet te jete i zbrazet');</script>";
		}else{
       
            $comment = $_POST['comment'];
            $rating = $_POST['rating'];
            $mql = "INSERT INTO comments (comment, rating) VALUES ('$comment', '$rating')";
            mysqli_query($db, $mql);
            
            $successMessage = "Vlersimi u ruajt me sukses,Faleminderit";

            }

    }


?>      <div class="success-message"><?php echo $successMessage; ?></div>

    </div>
</div>

                    </div>
                </div>
            </div>
        </div>
        <?php include "include/footer.php" ?>

    </div>

   
                   
    

    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <?php require('inc/links.php');?>
    <title>GRAND HOTEL - CONTACT</title>

</head>
<body class="bg-light">
    
    <?php require('inc/header.php')?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">CONTACT US</h2>
        <div class="h-line bg-dark ">

        </div>
        <p class="text-center mt-3">
            Welcome to GRAND HOTEL, where comfort and hospitality meet! If you have any questions or need help with booking, our team is just a message or call away.<br> Reach out to us anytime,and we'll make sure all your needs are taken care of. Contact us today, and we will be happy to assist you in planning your perfect stay!"
        </p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 px-4">

                <div class="bg-white rounded shadow p-4">
                    <iframe class="w-100 rounded mb-4" src="<?php echo $contact_r['iframe'] ?>" height="320px" loading="lazy"></iframe>
                    
                    <h5>Address</h5>
                    <a href="<?php echo $contact_r['gmap'] ?>" target="_blank" class="d-inline-block text-decoration-none text-dark mb-2">
                        <i class="bi bi-geo-alt-fill me-1"></i><?php echo $contact_r['address'] ?>
                    </a>
                    
                    <h5 class="mt-4">Call Us</h5>
                    <a href="tel: +<?php echo $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill me-1"></i> +<?php echo $contact_r['pn1'] ?>
                    </a>
                    <br>

                    <?php
                        if($contact_r['pn2']!=''){
                            echo <<<data
                                <a href="tel: +$contact_r[pn2]" class="d-inline-block text-decoration-none text-dark">
                                    <i class="bi bi-telephone-fill me-1"></i> +$contact_r[pn2]
                                </a>
                            data;
                        }
                    ?>
                                       
                    <h5 class="mt-4">Email</h5>
                    <a href="mailto: <?php echo $contact_r['email'] ?>" class="d-inline-block text-decoration-none text-dark"><i class="bi bi-envelope-fill me-1"></i> <?php echo $contact_r['email'] ?></a>
                    <br>

                    <h5 class="mt-4">Follow Us</h5>
                    <?php
                        if($contact_r['tw']!=''){
                            echo <<<data
                                <a href="$contact_r[tw]" class="d-inline-block text-dark fs-5 me-2">
                                    <i class="bi bi-twitter-x me-1"></i>
                                </a>
                            data;
                        }
                    ?>
                    
                    <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block text-dark fs-5 me-2">
                        <i class="bi bi-facebook me-1"></i>
                    </a>

                    <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block text-dark fs-5">
                        <i class="bi bi-instagram me-1"></i>
                    </a>
                </div>

            </div>

            <div class="col-lg-6 col-md-6 px-4">
                <div class="bg-white rounded shadow p-4">
                    <form method="POST">
                        <h5>Send a message</h5>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Username</label>
                            <input type="text" name="name" required class="form-control shadow-none">
                        </div>   
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Email</label>
                            <input type="email" name="email" required class="form-control shadow-none">
                        </div>  
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Subject</label>
                            <input type="text" name="subject" required class="form-control shadow-none">
                        </div> 
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Message</label>
                            <textarea name="message" required class="form-control shadow-none" rows="5" style="resize: none;"></textarea>
                        </div> 
                        <button type="submit" name="send" class="btn text-white custom-bg mt-3">SEND</button>
                    </form>
                </div>
            </div>            
        </div>
    </div>

    <?php
        if(isset($_POST['send'])){
            $frm_data = filteration($_POST);
            $q = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
            $values = [$frm_data['name'], $frm_data['email'], $frm_data['subject'], $frm_data['message']];
            $res = insert($q,$values,'ssss');
            if($res == 1){
                alert('success', 'Mail sent!');
            }
            else{
                alert('error', 'Server down! Try again later.');
            }
        }
    ?>
    
    <?php require('inc/footer.php') ?>
    
</body>
</html>
<!-- Footer -->
<div class="container-fluid bg-white shadow-sm mt-5 px-4">
    <div class="row">
        <div class="col-lg-4 p-4">
            <h3 class="h-font fw-bold fs-3 mb-2"><?php echo $settings_r['site_title'] ?></h3>
            <p>
                <?php echo $settings_r['site_about'] ?>                
            </p>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Links</h5>
            <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a><br>
            <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Rooms</a><br>
            <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Facilities</a><br>
            <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contact Us</a><br>
            <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">About</a><br>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Follow Us</h5>
            <?php
            if ($contact_r['tw'] != '') {
                echo <<<data
                    <a href="$contact_r[tw] " class="d-inline-block text-dark text-decoration-none mb-2">
                        <i class="bi bi-twitter-x me-1"></i> Twitter
                    </a>
                    <br>
                data;
            }
            ?>

            <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block text-dark text-decoration-none mb-2">
                <i class="bi bi-facebook me-1"></i> Facebook
            </a>
            <br>
            <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block text-dark text-decoration-none">
                <i class="bi bi-instagram me-1"></i> Instagram
            </a>
            <br>
        </div>
    </div>
</div>


<h6 class="text-center bg-dark text-white p-3 m-0">&copy; Choose your grand rooms in Grand Hotel! All Rights Reserved
</h6>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>

<script>

    function alert(type, msg, position = 'body') {
        let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
        let element = document.createElement('div');
        element.innerHTML = `
            <div class="alert ${bs_class} alert-dismissible fade show" role="alert">
                <strong class="me-3">${msg}</strong> 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        if(position == 'body'){
            document.body.append(element);
            element.classList.add('custom-alert');
        }
        else{
            document.getElementById(position).appendChild(element);
        }        
        setTimeout(remAlert, 3000);
    }

    function remAlert() {
        document.getElementsByClassName('alert')[0].remove();
    }

    function setActive() {
        let navbar = document.getElementById('nav-bar');
        let a_tags = navbar.getElementsByTagName('a');

        for (i = 0; i < a_tags.length; i++) {
            let file = a_tags[i].href.split('/').pop();
            let file_name = file.split('.')[0];

            if (document.location.href.indexOf(file_name) >= 0) {
                a_tags[i].classList.add('active');
            }
        }
    }

    // let register_form = document.getElementById('register-form');

    // register_form.addEventListener('submit', (e) => {
    //     e.preventDefault();

    //     let data = new FormData();

    //     data.append('name', register_form.elements['name'].value);
    //     data.append('email', register_form.elements['email'].value);
    //     data.append('pass', register_form.elements['pass'].value);
    //     data.append('cpass', register_form.elements['cpass'].value);
    //     data.append('register', '');

    //     var myModal = document.getElementById('registerModal');
    //     var modal = bootstrap.Modal.getInstance(myModal);
    //     modal.hide();

    //     let xhr = new XMLHttpRequest();
    //     xhr.open("POST", "ajax/login_register.php", true);

    //     xhr.onload = function () {
    //         if (this.responseText == 'pass_mismatch') {
    //             alert('error', "Password Mismatched!");
    //         }
    //         else if(this.responseText == 'email_already'){
    //             alert('error', "Email is already registered!");
    //         }
    //         else if(this.responseText == 'ins_failed'){
    //             alert('error', "Registration failed! Server down!");
    //         }
    //         else{
    //             alert('success', 'Registration successfull!');
    //             register_form.reset();
    //             // window.location.href = "index.php";
    //         }
    //     }

    //     xhr.send(data);
    // });


    // let signin_form = document.getElementById('signin-form');

    // signin_form.addEventListener('submit', (e) => {
    //     e.preventDefault();

    //     let data = new FormData();

    //     data.append('email', signin_form.elements['email'].value);
    //     data.append('pass', register_form.elements['pass'].value);
    //     data.append('signin', '');

    //     var myModal = document.getElementById('signinModal');
    //     var modal = bootstrap.Modal.getInstance(myModal);
    //     modal.hide();

    //     let xhr = new XMLHttpRequest();
    //     xhr.open("POST", "ajax/login_register.php", true);

    //     xhr.onload = function () {
    //         if (this.responseText == 'inv_email') {
    //             alert('error', "Invalid Email!");
    //         }
    //         else if(this.responseText == 'inactive'){
    //             alert('error', "Account suspended! Please contact admin!");
    //         }
    //         else if(this.responseText == 'invcalid_pass'){
    //             alert('error', "Incorrect Password!");
    //         }
    //         else{
    //             window.location = window.location.pathname;
    //         }
    //     }

    //     xhr.send(data);
    // });


    setActive();
</script>
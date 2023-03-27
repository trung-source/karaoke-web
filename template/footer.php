

<!-- start #footer -->
<footer id="footer" class="bg-dark text-white py-5 wow flipInX" data-wow-delay="0.3s">
        <div class="containter">
            <div class="row">
                <div class="col-lg-4 col-12">
                    <h4 class="font-rubik font-size-20">Karaoke</h4>
                    <p class="font-size-14 font-rale text-white-50">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Distinctio odio fugiat, voluptas quaerat cumque alias libero explicabo, ducimus corrupti quam fugit, enim architecto amet numquam laudantium reprehenderit quis veritatis ad?</p>
                </div>

                <div class="col-lg-7 col-12">
                    <h4 class="font-rubik font-size-20">Newslatter</h4>
                    <form class="form-row">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Email *">                            
                        </div>

                        <div class="col">
                            <button type="submit" class="btn btn-primary mb-2">Subscribe</button>
                        </div>

                        <div class="col-lg-5 col-12">
                            <h4 class="font-rubik font-size-20">Information</h4>
                            <div class="d-flex flex-column flex-wrap">
                                <a href="about.php" class="font-rale font-size-14 text-white-50 pb-1">About us</a>
                                <a href="#" class="font-rale font-size-14 text-white-50 pb-1">Delivery information</a>
                                <a href="#" class="font-rale font-size-14 text-white-50 pb-1">Privacy Policy</a>
                                <a href="#" class="font-rale font-size-14 text-white-50 pb-1">Terms & Conditions</a>
                            </div>
                        </div>

                        <div class="col-lg-2 col-6">
                                <h4 class="font-rubik font-size-20">Account</h4>
                                <!-- <a href="#" class="font-rale font-size-14 text-white-50 pb-1">My Account</a><br> -->
                                <a href="order.php" class="font-rale font-size-14 text-white-50 pb-1">Order</a><br>
                                <a href="bill.php" class="font-rale font-size-14 text-white-50 pb-1">Cart</a><br>
                                <a href="index.php" class="font-rale font-size-14 text-white-50 pb-1">Home</a><br>

                        </div>
                        
                    </form>
                </div>

            </div>
        </div>
    </footer>

    <div class="copyright text-center bg-dark text-white py-4 wow flipInX" data-wow-delay="0.4s">
        <p class="font-rale font-size-20">&copy: Copyrights 2022: Design By Vũ Trung</p>
    </div>
    <!-- !start #footer -->



    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.21/moment-timezone-with-data-2012-2022.min.js"></script>
    
    
    
    
    <!-- Owl Carousel js file -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- TempusDominus -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- isotop plugin cdn-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    
    <!-- wow -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    
    <!-- Custom JavaScript -->
    <script src="./index.js"></script>
    <script>
        // play/pause video
        let video = document.querySelector('.video-wrapper video');
        document.getElementById('play-btn').addEventListener('click', () => {
            if(video.paused){
                video.play();
            } else {
                video.pause();
            }
        });
    </script>


</body>
</html>



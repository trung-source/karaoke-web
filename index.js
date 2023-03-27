$(document).ready(function(){

    // Banner owl carousel
    $("#banner-area .owl-carousel").owlCarousel({
        dots:true,
        loop:true,
        items:1
    });

    // Banner owl carousel
    $("#phong-vip .owl-carousel").owlCarousel({
        dots:false,
        nav:true,
        loop:true,
        animateOut: 'fadeOut',
        responsive : {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000 : {
                items: 4
            }
        }


    });

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    

    // khoi tao wow
    new WOW().init();

    // Gioi thieu owl carousel
    $("#events .owl-carousel").owlCarousel({
        dots:false,
        nav:true,
        loop:true,

        responsive : {
            0: {
                items: 1
            },
            600: {
                items: 3
            }
        }


    });

   

   // Dropdown on mouse hover
   const $dropdown = $(".dropdown");
   const $dropdownToggle = $(".dropdown-toggle");
   const $dropdownMenu = $(".dropdown-menu");
   const showClass = "show";
   
   $(window).on("load resize", function() {
       if (this.matchMedia("(min-width: 992px)").matches) {
           $dropdown.hover(
           function() {
               const $this = $(this);
               $this.addClass(showClass);
               $this.find($dropdownToggle).attr("aria-expanded", "true");
               $this.find($dropdownMenu).addClass(showClass);
           },
           function() {
               const $this = $(this);
               $this.removeClass(showClass);
               $this.find($dropdownToggle).attr("aria-expanded", "false");
               $this.find($dropdownMenu).removeClass(showClass);
           }
           );
       } else {
           $dropdown.off("mouseenter mouseleave");
       }
   });
    
    
    


    


    // BLogs owl carousel
    $("#review .owl-carousel").owlCarousel({
        loop: true,
        nav: false,
        dots: false,
        // depend on the viewport of the device : items appear will be different
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            }
        }
    });

    // BLogs owl carousel
    $("#blogs .owl-carousel").owlCarousel({
        loop: true,
        nav: false,
        dots: true,
        // depend on the viewport of the device : items appear will be different
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            }
        }
    });

    
    // // video
    // const menuToggle = document.querySelector('.toggle');
    // const showcase = document.querySelector('.showcase');

    // menuToggle.addEventListener('click', () => {
    //   menuToggle.classList.toggle('active');
    //   showcase.classList.toggle('active');
    // })
    



    // isotope filer
    var $grid =$(".grid").isotope({
        itemSelector:'.grid-item',
        layoutMode:'fitRows'
    });

    // filer items on buttons click
    $(".button-group").on("click","button",function(){
        var filterValue = $(this).attr("data-filter");
        $grid.isotope({filter:filterValue});
    })



    // // BLogs owl carousel
    // $("#blogs .owl-carousel").owlCarousel({
    //     loop: true,
    //     nav: false,
    //     dots: true,
    //     // depend on the viewport of the device : items appear will be different
    //     responsive:{
    //         0:{
    //             items:1
    //         },
    //         600:{
    //             items:3
    //         }
    //     }
    // })




    // product qty section
    let $qty_up = $(".qty .qty-up");
    let $qty_down = $(".qty .qty-down");
    // let $input = $(".qty .qty_input");

    // click on qty up button
    $qty_up.click(function(e){
        let $input = $(`.qty_input[data-id='${$(this).data("id")}']`);
        if($input.val() >= 1 && $input.val() <= 9){
            $input.val(function(i, oldval){
                return ++oldval;
            })
        }
    });

    // click on qty down button
    $qty_down.click(function(e){
        let $input = $(`.qty_input[data-id='${$(this).data("id")}']`);
        if($input.val() >= 2 && $input.val() <= 10){
            $input.val(function(i, oldval){
                return --oldval;
            })
        }
    });

    

    // Closing small window (product page)
 document.querySelector('#close-update-1').onclick = () =>{
    document.querySelector('.edit-room-form').style.display = 'none';
    window.location.href = 'admin_product.php';
 }

});
 


  // Closing small window (room page)
  document.querySelector('#close-update').onclick = () =>{
    document.querySelector('.edit-room-form').style.display = 'none';
    window.location.href = 'admin_room.php';
};




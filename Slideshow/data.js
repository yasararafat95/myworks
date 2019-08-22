// JavaScript Document
$(document).ready(function(){
                
                
var total_slides = 5;
                
$(".slide_cont").css({'width': (total_slides * 100) + '%'});
                
$(".inside_images").css({'width': (100 / total_slides) + '%'});
                
$(".dots_cont").css({'width': (total_slides * 35) + 'px'});
                
var slide_count = 0;
                
$(document).off("click", ".left_arrow.enable");
$(document).on("click", ".left_arrow.enable", function(){
                
                slide_count = slide_count - 1;
                
                $(".slide_cont").css({'margin-left': (slide_count * -100) + '%'});
                
                check_navigation();
                
});
                
                
$(document).off("click", ".right_arrow.enable");
$(document).on("click", ".right_arrow.enable", function(){
                
                slide_count = slide_count + 1;
                
                $(".slide_cont").css({'margin-left': (slide_count * -100) + '%'});
                
                check_navigation();
                
});
                
                
$(document).off("click", ".dots_cont span");
$(document).on("click", ".dots_cont span", function(){
                
                slide_count = $(this).index();
                
                $(".dots_cont span").removeClass("active");
                
                $(this).addClass("active");
                
                $(".slide_cont").css({'margin-left': (slide_count * -100) + '%'});
                
                check_navigation();
                
});
                
                
                
function check_navigation(){
                
                $(".dots_cont span").removeClass("active");
                
                $(".dots_cont span").eq(slide_count).addClass("active");
                
                if(slide_count==0){
                                $(".left_arrow").removeClass("enable");
                } else {
                                $(".left_arrow").addClass("enable");
                }
                
                if(slide_count==total_slides-1){
                                $(".right_arrow").removeClass("enable");
                } else {
                                $(".right_arrow").addClass("enable");
                }
                
}
                
                
                
});

$(document).ready(function(){
  $('.carouselNew').bxSlider({
  	slideWidth: 200,
    minSlides: 2,
    maxSlides: 8,
    slideMargin: 10
  });
    $('.carouselPopular').bxSlider({
  	slideWidth: 200,
    minSlides: 2,
    maxSlides: 8,
    slideMargin: 20
  });
});



function pVote(id){
  var xhr = new XMLHttpRequest()
   var formData = new FormData();
   formData.append('postid',id);
   xhr.open('POST', '../../pvote.php', true);
   xhr.onload = function () {
      if (xhr.status === 200) {
        // File(s) uploaded.
        console.log('vote received!')
      } else {
        alert('An error occurred!');
      }
      // Send the Data.
    };
    xhr.send(formData);
}

$('#pVoteButton').click(function(){
  alert('click');
  var postID = document.getElementById('pVoteButton').parentNode.children[0].innerHTML;
  pVote(postID);
})
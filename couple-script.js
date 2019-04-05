function displayVideos()
{
  var x = document.getElementById("cpl-photo-ele-container");
  var y = document.getElementById("cpl-video-ele-container");

  var a = document.getElementById("cpl-video-tag");
  var b = document.getElementById("cpl-photo-tag");

  a.style.borderBottom = "3px solid #ff7300";
  b.style.borderBottom = "none";

  y.style.display = "flex";
  y.style.flexWrap = "wrap";
  x.style.display = "none";
}

function displayPhotos()
{
  var x = document.getElementById("cpl-photo-ele-container");
  var y = document.getElementById("cpl-video-ele-container");

  var a = document.getElementById("cpl-video-tag");
  var b = document.getElementById("cpl-photo-tag");

  a.style.borderBottom = "none";
  b.style.borderBottom = "3px solid #ff7300";

  y.style.display = "none";
  x.style.display = "block";

  jQuery('.grid').masonry({
      // options...
    });
}

jQuery(document).ready(function()
{
    var gallery = jQuery('.gallery a').simpleLightbox();
    // init Masonry
    // jQuery('.grid').masonry({
    //   // options...
    // });
});
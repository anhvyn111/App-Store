//Developer
$(document).ready(function() {
  $("#alert-add-success").hide();
  $("#alert-edit-success").hide();
  $('#modal-delete-category').hide();
  $('#alert-error-gifcode').hide();
  $('#alert-recharge-fail').hide();
  $('#btn-post-rating').prop('disabled', true);
});


function delete_img(id, name){
  $.ajax({
      url: 'action.php',
      type: 'POST',
      data: {deleteImgID:id, name:name},
      success: function(result){
          $("#imgID_"+id).hide(1000);
      } 
  });
}

$("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});

function DeleteDraftID(id){
  $('#delete-draft-modal').modal('show');
  $(document).on('click','#btn-confirm-delete-draft',function(){
    $.ajax({
      url: 'action.php',
      type: 'POST',
      data: {deleteDraftID:id},
      success: function(result){
          $("#draft-id-"+id).hide();
          $('#delete-draft-modal').modal('hide');
        } 
    });
  }); 
}


//Admin

$("#menu-toggle-admin").click(function(e) {
  e.preventDefault();
  $("#wrapper-admin").toggleClass("toggled");
});

function AddCategory(){
  $('#modal-add-category').modal('show');
  $(document).on('click','#btn-add-category',function(){
    var categoryName = $('#category-name').val().trim();
    if(categoryName == ''){
      var html = '';
    }
    else{
      $.ajax({
        url: 'action.php',
        type: 'POST',
        data: {categoryName:categoryName},
        success: function(result){
          $('#modal-add-category').modal('hide');
          location.reload();
          $("#alert-add-success").fadeTo(2000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
          });
        }
      });
    }
  });
}

function EditCategory(categoryID, name){
  document.getElementById("category-name-edit").value = name;
  $('#modal-edit-category').modal('show');
  $(document).on('click','#btn-edit-category',function(){
    editCategoryName = document.getElementById("category-name-edit").value;
    if(editCategoryName != '' || editCategoryName != name){
      $.ajax({
        url: 'action.php',
        type: 'POST',
        data: {editCategoryName:editCategoryName,
              categoryID:categoryID},
        success: function(result){
          $('#modal-edit-category').modal('hide');
          location.reload();
          $("#alert-edit-success").fadeTo(2000, 500).slideUp(500, function() {
            $("#success-edit-alert").slideUp(500);
          });
          location.reload();
        }
      });
    }
  });
}
function DeleteCategory(deleteCategory){
  $('#modal-delete-category').modal('show');
  $(document).on('click','#btn-delete-category',function(){
    $.ajax({
      url: 'action.php',
      type: 'POST',
      data: {deleteCategory:deleteCategory},
      success: function(result){
          $("#category-id-"+deleteCategory).hide();
          $('#modal-delete-category').modal('hide');
        } 
    });
  }); 
}

function ApproveApp(adminApproveAppID){
    $.ajax({
      url: 'action.php',
      type: 'POST',
      data: {adminApproveAppID:adminApproveAppID}
    });
}

function CreateGiftcode(){
  var amountGiftcode = document.getElementById("amount-giftcode").value;
  var costGiftcode = document.getElementById("cost-giftcode").value;
  if(amountGiftcode != '' && costGiftcode != ''){
    if(costGiftcode == 50000 || costGiftcode == 100000 || costGiftcode == 200000 || costGiftcode == 500000){
      $.ajax({
        url: 'action.php',
        type: 'POST',
        data: {amountGiftcode:amountGiftcode,
          costGiftcode:costGiftcode},
        success: function(result){
          location.reload();
        }
      });
    }
    else{
      $('#alert-error-gifcode').fadeTo(2000, 500).slideUp(500, function() {
       $('#alert-error-gifcode').slideUp(500);
   });
  }
  }
  else{
    $('#alert-error-gifcode').fadeTo(2000, 500).slideUp(500, function() {
      $('#alert-error-gifcode').slideUp(500);
    });
  }
}

//STORE
$("input[type='image']").click(function() {
  $("input[id='avatar-file']").click();
});

$("#btn-buyapp").click(function () {
  $('#modal-buy-app').modal('show');
});

function ReviewApp(){
  $.ajax({
    url: 'process.php',
    type: 'POST',
    data: {BuyAppID : BuyAppID},
    success: function(result){
      if(result == 0){
         $('#btn-buy-success').modal('show');
       }
       else if(result == 1){
        $('#message-buy-error').html("<p>Số dư của bạn không đủ. Vui lòng nạp thêm.</p>");
      }
      else if(result == 2){
        $('#message-buy-error').html("<p>Đã có lỗi xảy ra.</p>");
      }
    }
  });
}

$('.rating').click(function(){
  $('#btn-post-rating').prop('disabled', false);
});

function EditRating(content, rate){
  document.getElementById("ratingContent-modal").value = content;
  document.getElementById("star"+rate).checked = true;
  $('#btn-post-rating').prop('disabled', false);
}

function ReadMore() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("myBtn");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more";
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less";
    moreText.style.display = "inline";
  }
}



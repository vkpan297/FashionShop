
function addToCart(event){
    event.preventDefault();
    let url=$(this).data('url');
    var qty=$('.pro_qty').val();
    $.ajax({
        type:"GET",
        url: url,
        data:{
            qty:qty,
        },
        success:function (data){
            if(data.code === 200){
                alert('Thêm sản phẩm vào giỏ hàng thành công');
            }
        },
        error:function (){

        }
    });
}
$(function (){
    $('.add_cart').on('click',addToCart);
});

$(function (){
    $('.cart_quantity_input').on('change',ChangeQty);
});

function ChangeQty(){
    var qty=$('.cart_quantity_input').val();
    var max_qty=$('.cart_quantity_max').val();
    if(qty>max_qty){
        alert('Số lượng bạn nhập vào vượt quá số lượng trong kho! Vui lòng nhập lại !');
    }
}

function view(){
    if(localStorage.getItem('data') != null){
        var data=JSON.parse(localStorage.getItem('data'));
        data.reverse();
        document.getElementById('row_wishlist').style.overflow='scroll';
        document.getElementById('row_wishlist').style.height='600px';

        for(i=0;i<data.length;i++){
            var name=data[i].name;
            var price=data[i].price;
            var image=data[i].image;
            var url=data[i].url;
            $('#row_wishlist').append('<div class="row" style="margin:10px 0"><div class="col-md-4"><img src="'+image+'" width="100%"></div><div class="col-md-8 info_wishlist"><p>'+name+'</p><p style="color:#FE980F">'+price+'</p><a href="'+url+'">Mô tả</a></div></div>');
        }
    }
}
view();

function add_wishlist(clicked_id){
    var id=clicked_id;
    var name=document.getElementById('pro_name'+id).value;
    var price=document.getElementById('pro_price'+id).value;
    var image=document.getElementById('img_path'+id).src;
    var url=document.getElementById('pro_url'+id).href;

    var newItem={
        'id':id,
        'name':name,
        'price':price,
        'image':image,
        'url':url
    }

    if(localStorage.getItem('data')==null){
        localStorage.setItem('data','[]');
    }

    var old_data=JSON.parse(localStorage.getItem('data'));

    var matches=$.grep(old_data,function(obj){
        return obj.id==id;
    });

    if(matches.length){
        alert("Sản phẩm bạn đã yêu thích,nên không thể thêm");
    }else{
        old_data.push(newItem);
        $('#row_wishlist').append('<div class="row" style="margin:10px 0"><div class="col-md-4"><img src="'+newItem.image+'" width="100%"></div><div class="col-md-8 info_wishlist"><p>'+newItem.name+'</p><p style="color:#FE980F">'+newItem.price+'</p><a href="'+newItem.url+'">Mô tả</a></div></div>');
    }
    localStorage.setItem('data',JSON.stringify(old_data));
}


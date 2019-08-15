<style type="text/css">
    .table {
        border-collapse: collapse;
        border: none;
        height: 255px;
        width: 800px;
    }

    td {
        border: solid #000 1px;
    }
    .add {
        border-collapse: collapse;
        border: none;
        width: 500px;
        height: 255px;

    }
</style>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>购物车</title>
</head>
<body>
<div class="body">
    <table class="table" border="1">
        <tr>
            <td>全选 <input type="checkbox"></td>
            <td>ID</td>
            <td>商品名</td>
            <td>商品价格</td>
            <td>个数</td>
            <td>总价</td>
            <td>操作</td>
        </tr>
        @foreach($arr as $v)
        <tr>
            <td><input type="checkbox" class="box" car_id="{{$v->car_id}}" sum="{{$v->goods_price*$v->buy_number}}"> </td>
            <td>{{$v->car_id}}</td>
            <td>{{$v->goods_name}}</td>
            <td >{{$v->goods_price}}</td>
            <td class="buy_number">{{$v->buy_number}}</td>
            <td>{{$v->goods_price*$v->buy_number}}</td>
            <td>
                <a href="javascript:;" class="dele" car_id="{{$v->car_id}}">删除</a>|
                <input type="button" class="plus" value="＋" car_id="{{$v->car_id}}" goods_num="{{$v->goods_num}}">
                <input type="text" disabled="disabled" class="num" id="val"id="{{$v->goods_id}}"  value="{{$v->buy_number}}"style="width: 40px;" goods_num="{{$v->goods_num}}">
                <input type="button" class="pop" value="－" goods_num="{{$v->goods_num}}"  car_id="{{$v->car_id}}">
            </td>
        </tr>
        @endforeach
    </table>
    <h3>
        <samp>
            &nbsp;&nbsp;&ensp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ensp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;总价:<b class="sumb">0</b>&ensp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ensp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&ensp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ensp;
            &nbsp;&ensp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ensp;
        </samp>
        <input type="button" value="立即结算" class="sub"></h3>
    <table border="1" id="ps">
        <tr>
            <td colspan="5">
                <samp style="color: #b91d19"><b>（已下架）</b></samp>是否全部<a href="javascript:;" id="del">删除</a>
            </td>
        </tr>
        <tr>
            <td>ID</td>
            <td>商品名</td>
            <td>商品价格</td>
            <td>单价</td>
            <td>总价</td>
        </tr>
        @foreach($below as $v)
            <tr>
                <td >{{$v->car_id}}</td>
                <td>{{$v->goods_name}}</td>
                <td>{{$v->goods_price}}</td>
                <td>{{$v->buy_number}}</td>
                <td>{{$v->goods_price*$v->buy_number}}</td>
            </tr>
        @endforeach
    </table>
</div>
<div class="body1">
    <table class="add">

    </table>
    &ensp;&ensp;&ensp;$<b class="sumy"></b>&ensp;&ensp;&ensp;
    &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
    &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
    <input type="button" value="提交订单">
</div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    $(function () {
        $(".body1").hide();
        $.get(
            '/Goodscret/judge',
            function (res) {
                var arr=JSON.parse(res);
                // console.log(arr);
                if(arr.on==0){
                    $("#ps").remove();
                    // $("#ps").hide();
                }
            }
        );
        //下架商品删除
        $("#del").click(function () {
            $("#ps").hide();
            $.get(
                '/Goodscret/del',
                function (res) {
                    var arr=JSON.parse(res);
                    if(arr.on==0){
                        alert(arr.mag);
                        window.location.reload(); //刷新当前页面.
                    }else{
                        alert(arr.mag);
                    }
                }
            );
        })

        //删除要删除的商品
        $(document).on("click",".dele",function () {
            var car_id=$(this).attr('car_id');
            $.get(
                '/Goodscret/dele?id='+car_id,
                function (res) {
                    var arr=JSON.parse(res);
                    if(arr.on==0){
                        alert(arr.mag);
                        window.location.reload(); //刷新当前页面.
                    }else{
                        alert(arr.mag);
                    }
                }
            );
        })
        //增
        $(document).on('click',".plus",function () {
            var val=$(this).next('input').val();
            val++;
            var goods_num=$(this).attr('goods_num');
            if(val>goods_num){
                $(this).attr("disabled", true);
            }else{
                $(this).parents('tr').find("[class='buy_number']").html(val)
                $(this).next('input').val(val);
            }
            var car_id=$(this).attr('car_id');
            var buy_number=$(this).parents('tr').find("[class='buy_number']").html();
            $.get(
                '/Goodscret/aa?car_id='+car_id+"&buy_number="+buy_number,
                function (res) {
                    var arr=JSON.parse(res);
                    if(arr.on==1){
                        alert(arr.mag);
                    }
                }
            );
        })
        //减
        $(document).on('click',".pop",function () {
            var val=$(this).prev('input').val();
            val--;
            if(val<=0){
                $(this).attr("disabled", true);
                // alert('不能再减了')
            }else{
                $(this).parents('tr').find("[class='buy_number']").html(val)
                $(this).prev('input').val(val);
            }
            var buy_number=$(this).parents('tr').find("[class='buy_number']").html();
            var car_id=$(this).attr('car_id');
            $.get(
                '/Goodscret/aa?car_id='+car_id+"&buy_number="+buy_number,
                function (res) {
                    // console.log(res);
                    var arr=JSON.parse(res);
                    if(arr.on==1){
                        // alert(arr.mag);
                    }
                }
            );

        })

        //复选框
        $(document).on('click','.box',function () {
            var sumb=parseInt($('.sumb').html());
            var sum="";
            $(this).each(function (index){
                if($(this).prop('checked')==true){
                    sum+=parseInt($(this).attr('sum'))+parseInt(sumb);
                    $('.sumb').html(sum)
                    $(this).parents('tr').find("input[class='plus']").attr("disabled", true);
                    $(this).parents('tr').find("input[class='pop']").attr("disabled", true);
                }else{
                    sum+=parseInt(sumb)-parseInt($(this).attr('sum'));
                    $('.sumb').html(sum)
                    $(this).parents('tr').find("input[class='plus']").attr("disabled", false);
                    $(this).parents('tr').find("input[class='pop']").attr("disabled", false);
                }
            })
        })

        //点击结算
        $(document).on('click','.sub',function() {
            $(".body1").show();
            var box=$(this).parents('body').find("input[class='box']");
            var car_id="";
            box.each(function (index){
                if($(this).prop('checked')==true){
                    car_id+=$(this).attr('car_id')+',';
                }
            })
            var  sum=$('.sumb').html();
            $.get(
                '/Order/lista?car_id='+car_id+'&sum='+sum,
                function (res) {
                    var arr=JSON.parse(res);
                    if(arr.on==1){
                        alert(arr.mag);
                    }else{
                        $('.body').hide();
                        var data = arr.data;
                        con = "";
                        $.each(data, function(index, item){
                            con += "<tr><td colspan='2'>"+item.c_name+"</td><td> "+item.goods_name+"</td></tr>";
                            con += "<tr><td  colspan='2'> X"+item.buy_number+"</td><td> 💴"+item.goods_price+"</td></tr>";
                        });
                        $(".add").html(con);
                        $(".sumy").html(arr.sum)
                        //把内容入到这个div中即完成
                    }

                }
            );
        })

    })
</script>
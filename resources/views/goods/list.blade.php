<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品展示</title>
</head>
<body>
<h2>商品展示</h2><h3><a href="/Goodscret/list">去购物车</a></h3>
<table>
    <tr>
        <td>ID</td>
        <td>商品名</td>
        <td>库存</td>
        <td>商品价格</td>
        <td>销售量</td>
        <td>操作</td>
    </tr>
    @foreach($arr as $v)
    <tr>
        <td>{{$v->goods_id}}</td>
        <td>{{$v->goods_name}}</td>
        <td >{{$v->goods_num}}</td>
        <td>{{$v->goods_price}}</td>
        <td >{{$v->goods_sales}}</td>
        <td>
            <input type="button" class="plus" value="＋" id="{{$v->goods_id}}" goods_num="{{$v->goods_num}}">
            <input type="text" class="num" id="val" value=""style="width: 40px;" goods_num="{{$v->goods_num}}">
            <input type="button" class="pop" value="－" goods_num="{{$v->goods_num}}">
            <a href="JavaScript:;" class="car" id="{{$v->goods_id}}">添加购物车</a>
        </td>
    </tr>
    @endforeach
</table>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    $(function () {
        $("#val").val(0);
        $(document).on('click',".plus",function () {
            var val=$(this).next('input').val();
            val++;
            var goods_num=$(this).attr('goods_num');
            if(val>goods_num){
                $(this).attr("disabled", true);
            }else{
                $(this).next('input').val(val);
            }
        })
        $(document).on('click',".pop",function () {
            var val=$(this).prev('input').val();
            val--;
            if(val<=0){
                $(this).attr("disabled", true);
                alert('不能再减了')
            }else{
                $(this).prev('input').val(val);
            }
        })
        $(document).on('blur',"#val",function () {
            // alert(11);
            var val=parents($(this).val());
            var goods_num=parents($(this).attr('goods_num'));
            // console.log(goods_num);
            if(goods_num<val){
                $(this).val(goods_num);
            }
        })
        $(document).on('click',".car",function () {
            var id=$(this).attr('id');
            var num=$(this).parent('td').find("input[class='num']").val();
            $.get(
                '/Goodscret/add?id='+id+'&num='+num,
                function (res) {
                    var arr=JSON.parse(res);
                    if(arr.on==0){
                        alert(arr.mag);
                    }else{
                        alert(arr.mag);
                    }
                }

            );
        })
    })
</script>
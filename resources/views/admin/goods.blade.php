<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品添加</title>
</head>
<body>
    <table>
        <tr>
            <td>商品名</td>
            <td><input type="text" name="goods_name"></td>
        </tr>
        <tr>
            <td>商品价格</td>
            <td><input type="text" name="goods_price"></td>
        </tr>
        <tr>
            <td>商品库存</td>
            <td><input type="text" name="goods_num"></td>
        </tr>
        <tr>
        <tr>
            <td></td>
            <td><input type="button" value="添加商品" id="sub"></td>
        </tr>
    </table>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(function () {
        $("#sub").click(function () {
            var goods_name=$("input[name='goods_name']").val();
            var goods_price=$("input[name='goods_price']").val();
            var goods_num=$("input[name='goods_num']").val();
            $.post(
                '/admin/goodsdo',
                {goods_name:goods_name,goods_price:goods_price,goods_num:goods_num},
                function (res) {
                    console.log(res);
                }
            );
        })
    })
</script>
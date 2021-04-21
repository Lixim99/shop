<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="item item-1">1</div>
        <div class="item item-2">2</div>
        <div class="item item-3">3</div>
        <div class="item item-4">4</div>
        <div class="item item-5">5</div>
        <div class="item item-6">6</div>
        <div class="item item-7">7</div>
        <div class="item item-8">8</div>
        <div class="item item-9">9</div>
        <div class="item item-10">10</div>
    </div>
    <div class="additional-text">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae sodales ante. Nunc commodo quis sapien in ullamcorper. Integer laoreet metus sit amet quam fringilla rutrum. Curabitur nec ante luctus, mattis mi at, hendrerit sem. Donec vel diam euismod, lobortis nibh ac, pretium nisl. Curabitur id feugiat nulla, et sollicitudin massa. Proin sagittis posuere ligula et malesuada.

        Mauris suscipit sit amet justo ac vulputate. Pellentesque tempor tincidunt nisi. Proin tempus pellentesque libero vitae faucibus. Morbi semper magna eget elit vulputate ultricies. Praesent viverra ipsum in sem vestibulum dictum. Aenean hendrerit, neque ac suscipit fringilla, orci arcu hendrerit mi, eu aliquam arcu eros at mauris. Nam vel euismod nunc. Aenean egestas suscipit libero, vel fermentum turpis rutrum id. Aenean turpis mauris, tincidunt ut hendrerit id, lobortis nec tellus. Donec varius congue gravida. Sed vel elit non dui viverra condimentum. Sed eu efficitur justo. Phasellus ac consectetur leo, fermentum auctor risus. Sed vulputate egestas ullamcorper.

        Aliquam vel elit hendrerit, interdum elit id, efficitur diam. Cras in nisi eget purus maximus consequat. Integer non facilisis lorem. Sed dignissim id leo a dictum. Nulla semper libero non lorem convallis, quis dignissim lacus convallis. In nunc enim, malesuada egestas molestie id, gravida non nunc. Proin sed convallis odio. Sed porta ultricies suscipit. Integer sed aliquam justo, et euismod tortor. Curabitur ligula nulla, fringilla nec neque eget, iaculis accumsan nisl. Proin cursus vitae dui id dictum. In et arcu vitae dui gravida tempus. Fusce gravida leo sollicitudin ex pharetra aliquam. Nam aliquam tristique erat eu luctus. Cras metus orci, suscipit non turpis a, sagittis vehicula magna.
    </div>
</body>
</html>
<style>
    /*grid*/
    /*.container {*/
    /*    display: grid;*/
    /*    grid-auto-rows: minmax(80px, auto);*/
    /*    grid-template-columns: repeat(4, 1fr);*/
    /*    column-gap: 15px;*/
    /*    row-gap: 15px;*/
    /*    padding-bottom: 15px;*/
    /*}*/

    /*.container div {*/
    /*    opacity: 0.5;*/
    /*    background-color: yellowgreen;*/
    /*    border-radius: 20px;*/
    /*}*/

    /*.container .item-1 {*/
    /*    grid-column-start: 1;*/
    /*    grid-column-end: 5;*/
    /*    z-index: 2;*/
    /*}*/

    /*.container .item-3 {*/
    /*    grid-column-start: 2;*/
    /*    grid-column-end: 4;*/
    /*    z-index: 1;*/
    /*}*/

    /*.container .item-6 {*/
    /*    grid-column-start: 2;*/
    /*    grid-column-end: 4;*/
    /*}*/

    /*.additional-text {*/
    /*    font-family: "Open Sans", sans-serif;*/
    /*    font-size: small;*/
    /*}*/

    /*****__flexbox__*****/
    .container {
        display: flex;
        flex-direction: row;
    }

    .container div:hover {
        /*flex-direction: column-reverse;*/
        background-color: #FF1493;
        cursor: pointer;
    }

    .container div {
        padding: 15px;
        background-color: #761c19;
        opacity: 0.7;
        border-radius: 15px;
        text-align: center;
        transition: background-color 1s ease-out 100ms;
    }


</style>

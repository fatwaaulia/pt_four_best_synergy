function preview() {
    frame.src = URL.createObjectURL(event.target.files[0]);
}
function preview2() {
    frame2.src = URL.createObjectURL(event.target.files[0]);
}

function priceDot(input) {
    let number = (input.value).split('.').join('');
    let price = number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    input.value = price;
}

function onlyDotNumber(input) {
    let filter = (input.value).replace(/[^0-9\.\-]/g, '');
    input.value = filter;
}

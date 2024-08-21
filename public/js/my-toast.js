var toastrOptions = {
    timeOut: 5000,
    closeButton: false,
    positionClass: "toast-bottom-right",
}

// function that shows the popup message on top of the screen
var successToastr = function(message) {
    toastr.remove()
    toastr.success(message, '', toastrOptions)
}

// function that shows the popup message on top of the screen
var errorToastr = function(message) {
    toastr.remove()
    toastr.error(message, '', toastrOptions)
}

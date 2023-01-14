let timeout;
$(document).ready(function() {
    $("#searchInput").keypress(function() {
        $(".initial-products").hide();
        $(".searched-products").remove();

        if ($(this).val().length >= 3) {
            clearTimeout(timeout);
            setTimeout(_ => {
                performSearchAsyncRequest($(this).val());
            }, 250);
        }
        if ($(this).val().length <= 0) {
            $(".searched-products").remove();
            $(".initial-products").show();
        }
    });
    $("#searchInput").keyup(function() {
        if ($(this).val().length <= 0) {
            $(".searched-products").remove();
            $(".initial-products").show();
        }
    });



});

/**
 * Performs async ajax post request to obtain and display products by filter search
 */
function performSearchAsyncRequest(searchValue) {
    $(".initial-products").hide();
    $(".searched-products").remove();
    $.ajax({
        type: "POST",
        url: "/products",
        data: {
            searchProducts: searchValue
        },
        dataType: 'json',
        success: function(response) {
            var arrayValues = Object.values(response)[1];
            for (var i = 0; i < arrayValues.length; i++) {
                // TODO: this has to be changed as the whole record list will be reworked
                $('#product-data-list').append('<tr class="data-list-item products-box searched-products searched-products-record"><td class="data-list-item-element searched-products">' + arrayValues[i].Title + '</td><td class="data-list-item-element searched-products">' + arrayValues[i].DiscountPrice + '</td><td class="data-list-item-element searched-products">' + arrayValues[i].Price + '</td><td class="data-list-item-element searched-products"><a href="/product?ID=' + arrayValues[i].ID + '"><span class="material-icons" title="edit record">edit_note</span></a><a href="/products?deleteProductID=' + arrayValues[i].ID + '"><span class="material-icons" title="delete record">delete</span></td></tr>');
            }
        },
        error: function(response) {
            console.error(response);
        }
    });
}
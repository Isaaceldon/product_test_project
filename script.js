$(document).ready(function () {
  function loadProductData() {
    $.getJSON("products.json", function (data) {
      let totalSum = 0;
      let tableHTML = '<table class="table table-bordered table-striped">';
      tableHTML +=
        "<thead><tr><th>Product Name</th><th>Quantity</th><th>Price per Item</th><th>Datetime Submitted</th><th>Total Value</th><th>Actions</th></tr></thead><tbody>";

      if (data.length === 0) {
        tableHTML +=
          '<tr><td colspan="6" class="text-center">No product available</td></tr>';
      } else {
        $.each(data, function (index, product) {
          tableHTML += `<tr>
                    <td>${product.product_name}</td>
                    <td>${product.quantity}</td>
                    <td>$${product.price}</td>
                    <td>${product.datetime}</td>
                    <td>$${product.total_value}</td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-button" data-index="${index}">Edit</button>
                    </td>
                </tr>`;
          totalSum += parseFloat(product.total_value);
        });

        tableHTML += `<tr><td colspan="4"><strong>Total Sum</strong></td><td><strong>$${totalSum.toFixed(
          2
        )}</strong></td><td></td></tr>`;
      }

      tableHTML += "</tbody></table>";
      $("#productTable").html(tableHTML);
    });
  }

  loadProductData();

  $("#productForm").on("submit", function (event) {
    event.preventDefault();

    $.ajax({
      type: "POST",
      url: "index.php",
      data: $(this).serialize(),
      success: function () {
        $("#productForm")[0].reset();
        $("#productIndex").val("");
        $("#submitButton").text("Submit");
        loadProductData();
      },
    });
  });

  $("#productTable").on("click", ".edit-button", function () {
    const index = $(this).data("index");

    $.getJSON("products.json", function (data) {
      const product = data[index];
      $("#productName").val(product.product_name);
      $("#quantity").val(product.quantity);
      $("#price").val(product.price);
      $("#productIndex").val(index);
      $("#submitButton").text("Update");
    });
  });
});

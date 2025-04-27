$(document).ready(function () {
  // Test API button functionality
  $("#test-api").click(function () {
    const apiUrl = "/api/tasks";
    const apiResponse = $("#api-response");

    apiResponse.html("Loading...");

    $.ajax({
      url: apiUrl,
      type: "GET",
      dataType: "json",
      success: function (data) {
        apiResponse.html("<pre>" + JSON.stringify(data, null, 2) + "</pre>");
      },
      error: function (xhr, status, error) {
        apiResponse.html("Error: " + error);
      },
    });
  });

  // AJAX form submission example (optional)
  $("form").on("submit", function (e) {
    // You can add AJAX form submission here if needed
  });
});

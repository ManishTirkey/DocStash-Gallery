const Response_div = document.getElementById("response");
document
  .getElementById("uploadForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent default form submission

    var formData = new FormData(this); // Create FormData object from the form

    // Make AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "upload.php", true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState == XMLHttpRequest.DONE) {
        if (xhr.status == 200) {
          Response_div.innerText = "Uploaded Successfully";
        } else {
          Response_div.innerText = "An Error is Occurred";
        }

        Reset();
      }
    };
    xhr.send(formData);
  });

function Reset() {
  setTimeout(() => {
    Response_div.innerText = "Upload Your Documents safely";
  }, 10000);
}

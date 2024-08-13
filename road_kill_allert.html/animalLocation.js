var x = document.getElementById("geolocation");
document.getElementById("getLocation").addEventListener("click", getLocation);


function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  x.innerHTML = "Latitude: " + position.coords.latitude +
  "<br>Longitude: " + position.coords.longitude;
}

document.querySelector("form"). addEventListener("submit", (event) => {
    event.preventDefault();
    alert("Thank you for your submission!");

    const animaltype = document.getElementById("Animal_type").value;
    const picture = document.getElementById("Picture").value;
    const location = x.innerHTML;

    const formdata = {
        animal: animaltype,
        picture: picture,
        location: location
    }
})
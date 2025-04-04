const profilePictureInput = document.getElementById("profile-picture");

profilePictureInput.addEventListener("change", (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = () => {
      document.querySelector(".image-upload img").src = reader.result;
    };
    reader.readAsDataURL(file);
  }
});

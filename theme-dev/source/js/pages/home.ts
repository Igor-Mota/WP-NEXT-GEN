document.addEventListener("DOMContentLoaded", () => {
  import("alpinejs")
    .then(({ default: Alpine }) => {
      Alpine.start();
    })
    .catch((error) => {
      console.error("Falha ao carregar Alpine.js dinamicamente:", error);
    });
});

const container = document.getElementById("certScroll");
const certificates = container.querySelectorAll(".certificate");

function updateCenterActive() {
  const containerRect = container.getBoundingClientRect();
  const centerX = containerRect.left + containerRect.width / 2;

  let closest = null;
  let minDistance = Infinity;

  certificates.forEach((cert) => {
    const rect = cert.getBoundingClientRect();
    const certCenterX = rect.left + rect.width / 2;
    const distance = Math.abs(centerX - certCenterX);

    if (distance < minDistance) {
      minDistance = distance;
      closest = cert;
    }
  });

  certificates.forEach((cert) => cert.classList.remove("active"));
  if (closest) closest.classList.add("active");
}

container.addEventListener("scroll", () => {
  requestAnimationFrame(updateCenterActive);
});

window.addEventListener("load", updateCenterActive);

const categories = Array.from(jCategory);

document.getElementById("searchBar").addEventListener("keyup", (e) => {
  const searchData = e.target.value.toLowerCase();
  const filteredData = categories.filter((item) =>
    item.title.toLowerCase().includes(searchData)
  );
  displayItem(filteredData);
});

const displayItem = (items) => {
  const rootElement = document.getElementById("root");
  rootElement.innerHTML = "";

  items.forEach((item) => {
    const { index, image, title, rate, av } = item;
    const jList = document.createElement("div");
    jList.className = "jList";
    jList.innerHTML = `
      <img src="${image}" alt="">
      <h3>${title}</h3>
      <p>${rate}</p>
      <span id="key">${av}</span>
    `;

    rootElement.appendChild(jList);

    // Add event listener for redirection
    jList.addEventListener("click", () => {
      window.location.href = `job-details.html?id=${index}`;
    });
  });
};

displayItem(categories);

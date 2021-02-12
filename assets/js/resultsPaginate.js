//paginator object
const Paginator = {
  x: null,
  y: null,
  pageUrl: "/derrick/results?page=",
  paginationContainer: document.getElementById("paginationContainer"),
  nextPage: document.getElementById("nextPage"),
  currentPage: document.getElementById("currentPage").value,
  previousPage: document.getElementById("previousPage"),
  totalPages: document.getElementById("totalPages").value,
  recordsPerPage: document.getElementById("recordsPerPage").value,
  display(target) {
    target.style.display = "inline-block";
  },
  hide(target) {
    target.style.display = "none";
  },
  createElement(tag, attributes, content) {
    const element = document.createElement(tag);
    for (let att in attributes) {
      element.setAttribute(att, attributes[att]);
    }
    element.textContent = content;
    return element;
  },
  createPageLink(currentPage, num) {
    for (let i = 0; i < num; i++) {
      const pageNumber = currentPage + i;
      if (pageNumber <= this.pageNum) {
        const pageNum = document.createElement("li");
        const pageNumLink = this.createElement(
          "a",
          {
            href: `${this.pageUrl}${currentPage + i}`,
          },
          `${currentPage + i}`
        );
        pageNum.appendChild(pageNumLink);
        this.paginationContainer.insertBefore(pageNum, this.nextPage);
      }
    }
  },
  paginatePage() {
    this.currentPage = Number(this.currentPage);
    this.recordsPerPage = Number(this.recordsPerPage);
    this.pageNum = Math.ceil(this.totalPages / this.recordsPerPage);
    if (this.currentPage / 2 <= 1) {
      if (this.currentPage < 1) {
        this.currentPage = 1;
      }
      // current page is the first page, create two additional page links
      this.createPageLink(this.currentPage, 2);
    } else {
      if (!(this.currentPage > this.pageNum)) {
        this.createPageLink(this.currentPage, 2);
      } else {
        this.createPageLink(this.currentPage, 0);
      }
    }
    this.x = this.previousPage.nextElementSibling.textContent;
    this.y = this.nextPage.previousElementSibling.textContent;

    if (this.x <= 1) {
      this.hide(this.previousPage);
    }

    if (this.y >= this.pageNum) {
      this.hide(this.nextPage);
    }

    if (this.currentPage > this.pageNum) {
      this.hide(this.previousPage);
      this.hide(this.nextPage);
    }
    this.setPrevNextUrl();
  },
  //set the next or previous url
  setPrevNextUrl() {
    this.previousPage.children[0].href =
      `${this.pageUrl}` + (this.x <= 1 ? Number(this.x) : Number(this.x) - 1);
    this.nextPage.children[0].href = `${this.pageUrl}` + (Number(this.y) + 1);
  },
};
window.addEventListener("load", () => Paginator.paginatePage());

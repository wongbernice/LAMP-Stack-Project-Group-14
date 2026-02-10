const urlBase = "http://157.245.13.179/api/contacts";

document.addEventListener("DOMContentLoaded", () => {
  // Must be logged in userID set
  if (typeof readCookie === "function") readCookie();
  if (typeof userId === "undefined" || userId < 1) {
    window.location.href = "login.html";
    return;
  }

  // UI elements
  const logoutBtn = document.getElementById("logoutBtn");

  const openAddBtn = document.getElementById("openAddBtn");
  const modalBackdrop = document.getElementById("modalBackdrop");
  const closeModalBtn = document.getElementById("closeModalBtn");
  const cancelBtn = document.getElementById("cancelBtn");
  const contactForm = document.getElementById("contactForm");
  const contactNameInput = document.getElementById("contactName");

  const searchInput = document.getElementById("searchInput");
  const searchBtn = document.getElementById("searchBtn");
  const contactsTbody = document.getElementById("contactsTbody");
  const resultCount = document.getElementById("resultCount");

  // Enable search controls after logged in
  searchInput.disabled = false;
  searchBtn.disabled = false;

  // Events
  logoutBtn.addEventListener("click", doLogout);

  openAddBtn.addEventListener("click", openModal);
  closeModalBtn.addEventListener("click", closeModal);
  cancelBtn.addEventListener("click", closeModal);
  modalBackdrop.addEventListener("click", (e) => {
    // click outside modal closes it
    if (e.target === modalBackdrop) closeModal();
  });

  contactForm.addEventListener("submit", (e) => {
    e.preventDefault();
    addContactFromModal();
  });

  searchBtn.addEventListener("click", () => {
    searchContacts(searchInput.value.trim());
  });

  searchInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      searchContacts(searchInput.value.trim());
    }
  });

  // Initial load: call search API with empty string returns all or "No Records Found"
  searchContacts("");
});

//helper function for the add contact modal
function openModal() {
  const modalBackdrop = document.getElementById("modalBackdrop");
  const contactNameInput = document.getElementById("contactName");
  modalBackdrop.hidden = false;
  contactNameInput.value = "";
  contactNameInput.focus();
}

function closeModal() {
  const modalBackdrop = document.getElementById("modalBackdrop");
  modalBackdrop.hidden = true;
}

// API CALLS ARE HERE
function addContactFromModal() {
  const name = document.getElementById("contactName").value.trim();
  if (!name) return;

  // add.php expects: userId, firstName, lastName (required), phone/email optional.
  const parsed = splitName(name);

  const payload = {
    userId: userId,
    firstName: parsed.firstName,
    lastName: parsed.lastName,
    phone: "",
    email: ""
  };

  fetch(urlBase + "/add.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload)
  })
    .then((res) => res.json())
    .then((json) => {
      if (json.error && json.error !== "") {
        alert(json.error);
        return;
      }
      closeModal();
      // refresh using whatever is currently in the search box
      const q = document.getElementById("searchInput").value.trim();
      searchContacts(q);
    })
    .catch(() => alert("Network error while adding contact."));
}

function searchContacts(query) {
  const contactsTbody = document.getElementById("contactsTbody");
  const resultCount = document.getElementById("resultCount");

  // Loading state
  contactsTbody.innerHTML = `
    <tr>
      <td class="muted">Loading...</td>
      <td class="actions"><button class="btn btn--secondary" type="button" disabled>Edit</button></td>
    </tr>
  `;
  resultCount.textContent = "—";

  fetch(urlBase + "/search.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ search: query, userId: userId })
  })
    .then((res) => res.json())
    .then((json) => {
      // search.php returns: { results:[ "...", ... ], error:"" } OR { error:"No Records Found" }
      if (json.error && json.error !== "") {
        renderNoContacts(json.error);
        return;
      }

      const results = Array.isArray(json.results) ? json.results : [];
      renderContacts(results);
    })
    .catch(() => {
      renderNoContacts("Network error while searching.");
    });
}

// Rendering
function renderNoContacts(message) {
  const contactsTbody = document.getElementById("contactsTbody");
  const resultCount = document.getElementById("resultCount");

  contactsTbody.innerHTML = `
    <tr>
      <td class="muted">${escapeHtml(message || "No contacts yet")}</td>
      <td class="actions"><button class="btn btn--secondary" type="button" disabled>Edit</button></td>
    </tr>
  `;
  resultCount.textContent = "0";
}

function renderContacts(names) {
  const contactsTbody = document.getElementById("contactsTbody");
  const resultCount = document.getElementById("resultCount");

  if (!names || names.length === 0) {
    renderNoContacts("No contacts yet");
    return;
  }

  // Your current search.php only returns Name strings (not IDs / phone / email)
  // So we can render names + a disabled Edit button for now (until your edit page/endpoint wiring).
  const rows = names
    .map((name) => {
      const safeName = escapeHtml(String(name));
      return `
        <tr>
          <td>${safeName}</td>
          <td class="actions">
            <button class="btn btn--secondary" type="button" disabled>Edit</button>
          </td>
        </tr>
      `;
    })
    .join("");

  contactsTbody.innerHTML = rows;
  resultCount.textContent = `${names.length}`;
}

// LOGOUT
function doLogout() {
  // Clear cookie by expiring it
  document.cookie = "firstName=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
  document.cookie = "lastName=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
  document.cookie = "userId=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
  document.cookie = "firstName=,lastName=,userId=;expires=Thu, 01 Jan 1970 00:00:00 GMT";

  window.location.href = "login.html";
}

// UTILITIES
function splitName(full) {
  // If user types only one wordsend lastName as "-" to satisfy required fields
  const parts = full
    .replace(/\s+/g, " ")
    .trim()
    .split(" ")
    .filter(Boolean);

  if (parts.length === 0) return { firstName: "", lastName: "-" };
  if (parts.length === 1) return { firstName: parts[0], lastName: "-" };

  return {
    firstName: parts[0],
    lastName: parts.slice(1).join(" ")
  };
}

function escapeHtml(str) {
  return str
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");
}

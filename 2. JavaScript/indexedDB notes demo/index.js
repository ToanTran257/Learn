// Create needed constants
const list = document.querySelector("ul");
const titleInput = document.querySelector("#title");
const bodyInput = document.querySelector("#body");
const form = document.querySelector("form");
const submitBtn = document.querySelector("form button");

// Create an instance of db object for us to store the open db in
let db;

window.onload = function () {
  // asynchronous, will check if db exists, not -> create (onupgradedneeded)
  let request = window.indexedDB.open("notes_db", 1);

  request.onerror = function () {
    console.log("Database failed to open");
  };

  request.onsuccess = function () {
    console.log("Database opened successfully");

    db = request.result;

    displayData();
  };

  // Setup the db tables if this has not already been done
  request.onupgradeneeded = function (e) {
    // Grab a reference to the opened db
    let db = e.target.result;

    // Create an objectStore to store our notes in (basically like a single table)
    let objectStore = db.createObjectStore("notes_os", {
      keyPath: "id",
      autoIncrement: true,
    });

    // Define what data items the objectStore will contain
    objectStore.createIndex("title", "title", { unique: false });
    objectStore.createIndex("body", "body", { unique: false });

    console.log("Database setup complete");
  };

  form.onsubmit = addData;

  function addData(e) {
    e.preventDefault();

    let newItem = { title: titleInput.value, body: bodyInput.value };

    // open a read/write db transaction, ready for adding the data
    let transaction = db.transaction(["notes_os"], "readwrite");

    // call an object store that's already beedn added to the db
    let objectStore = transaction.objectStore("notes_os");

    // Make a request to add our newItem object to the object store
    let request = objectStore.add(newItem);
    request.onsuccess = function () {
      titleInput.value = "";
      bodyInput.value = "";
    };

    transaction.oncomplete = function () {
      console.log("Transaction completed: database modification finished.");

      displayData();
    };

    transaction.onerror = function () {
      console.log("Transaction not opened due to error");
    };
  }

  function displayData() {
    // Here we empty the contents of the list element each time the display is updated
    // If you didn't do this, you'd get duplicates listed each time a new note is added
    while (list.firstChild) {
      list.removeChild(list.firstChild);
    }

    // open to read open (not 'readwrite')
    let objectStore = db.transaction("notes_os").objectStore("notes_os");
    objectStore.openCursor().onsuccess = function (e) {
      let cursor = e.target.result;

      // If there is still another data item to iterate through, keep running this code
      if (cursor) {
        const listItem = document.createElement("li");
        const h3 = document.createElement("h3");
        const para = document.createElement("p");

        listItem.appendChild(h3);
        listItem.appendChild(para);
        list.appendChild(listItem);

        h3.textContent = cursor.value.title;
        para.textContent = cursor.value.body;

        listItem.setAttribute("data-note-id", cursor.value.id);

        const deleteBtn = document.createElement("button");
        listItem.appendChild(deleteBtn);
        deleteBtn.textContent = "Delete";

        deleteBtn.onclick = (e) => {
          // retrieve the name of the task we want to delete. We need
          // convert it to a number before trying to use it IDB; IDB key
          // values are type-sensitive
          let noteId = Number(e.target.parentNode.getAttribute("data-note-id"));

          let transaction = db.transaction(["notes_os"], "readwrite");
          let objectStore = transaction.objectStore("notes_os");
          let request = objectStore.delete(noteId);

          transaction.oncomplete = function () {
            e.target.parentNode.parentNode.removeChild(e.target.parentNode);
            console.log("Note " + noteId + " deleted.");

            if (!list.firstChild) {
              let listItem = document.createElement("li");
              listItem.textContent = "No notes stored.";
              list.appendChild(listItem);
            }
          };
        };

        cursor.continue();
      } else {
        if (!list.firstChild) {
          const listItem = document.createElement("li");
          listItem.textContent = "No notes stored.";
          list.appendChild(listItem);
        }

        console.log("Notes all displayed");
      }
    };
  }
};

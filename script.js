$(document).ready(function () {
  loadArtists();

  $("#artistForm").submit(function (e) {
      e.preventDefault();
      let name = $("input[name='name']").val();
      $.post("controller.php", { action: "addArtist", name }, function () {
          $("input[name='name']").val("");
          loadArtists();
      });
  });
});

function loadArtists() {
  $.post("controller.php", { action: "getData" }, function (res) {
      let data = JSON.parse(res);
      let html = "";

      data.forEach(artist => {
          html += `
            <table>
              <thead>
                <tr>
                  <th colspan="4">
                    <span>${artist.name}</span>
                    <button onclick="editArtistName(${artist.id}, '${artist.name}')">Edit Artist</button>
                    <button onclick="deleteArtist(${artist.id})">Delete Artist</button>
                    <div class="small">
                      Added by: ${artist.created_by}<br>
                      Updated by: ${artist.updated_by_username || 'N/A'}<br>
                      Last updated: ${artist.updated_at || 'N/A'}
                    </div>

                  </th>
                </tr>
                <tr>
                  <th>Song Title</th>
                  <th>Edit</th>
                  <th>Delete</th>
                  <th class="small">Activity</th>
                </tr>
              </thead>
              <tbody>`;

          artist.songs.forEach(song => {
              html += `
                <tr>
                  <td>${song.title}</td>
                  <td><button onclick="editSongTitle(${song.id}, '${song.title}')">🖊️</button></td>
                  <td><button onclick="deleteSong(${song.id})">🗑</button></td>
                  <td class="small">
                    Added by: ${song.created_by || 'Unknown'}<br>
                    Updated by: ${song.updated_by || 'N/A'}<br>
                    Last updated: ${song.updated_at || 'N/A'}
                  </td>
                </tr>`;
          });

          html += `
              <tr>
                <td colspan="4">
                  <form onsubmit="addSong(event, ${artist.id})">
                    <input name="title" placeholder="New Song Title" required>
                    <button>Add Song</button>
                  </form>
                </td>
              </tr>
              </tbody>
            </table>`;
      });

      $("#artistList").html(html);
  });
}

function editSongTitle(songId, currentTitle) {
  const newTitle = prompt("Edit song title:", currentTitle);
  if (newTitle && newTitle.trim() !== "" && newTitle !== currentTitle) {
      $.post("controller.php", {
          action: "editSong",
          id: songId,
          newTitle: newTitle.trim()
      }, function () {
          loadArtists(); 
      });
  }
}

function editArtistName(artistId, currentName) {
  const newName = prompt("Edit artist name:", currentName);
  if (newName && newName.trim() !== "" && newName !== currentName) {
      $.post("controller.php", {
          action: "editArtist",
          id: artistId,
          newName: newName.trim()
      }, function () {
          loadArtists();
      });
  }
}


function addSong(e, artist_id) {
  e.preventDefault();
  let form = e.target;
  let title = form.title.value;
  $.post("controller.php", { action: "addSong", title, artist_id }, function () {
      form.title.value = "";
      loadArtists();
  });
}

function deleteArtist(id) {
  if (confirm("Delete artist and all their songs?")) {
      $.post("controller.php", { action: "deleteArtist", id }, loadArtists);
  }
}

function deleteSong(id) {
  if (confirm("Delete song?")) {
      $.post("controller.php", { action: "deleteSong", id }, loadArtists);
  }
}


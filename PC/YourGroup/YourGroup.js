const groups = [
    {
        name: "Group A",
        description: "This is Group A",
        role: "Member",
        rumpun: "HMJ",
        session: 1,
        x: "20/11/2025",
        y: "21/11/2025"
    },
    {
        name: "Group B",
        description: "This is group B.",
        role: "Pengurus",
        rumpun: "Penalaran",
        session: 0
    },
    {
        name: "Group C",
        description: "This is group C.",
        role: "Member",
        rumpun: "Kesenian&MediaInformasi",
        session: 1,
        x: "05/12/2025",
        y: "06/12/2025"
    },
    {
        name: "Group D",
        description: "This is group D.",
        role: "Aktivis",
        rumpun: "Kerohanian&mMasyarakat",
        session: 1,
        x: "05/12/2025",
        y: "06/12/2025"
    },
    {
        name: "Group E",
        description: "This is group D.",
        role: "Aktivis",
        rumpun: "Olahraga&Beladiri",
        session: 0
    }
];

function createGroupCard(g) {
    return `
    <div class="group">
        <div class="left">
            <div class="group-pic"><p>Group Pic</p></div>
            <div class="role">
                <p>Your Role:</p>
                <p>${g.role}</p>
            </div>
        </div>

        <div class="right">
            <div class="group-name">
                <h2>${g.name}</h2>
            </div>

            <div class="group-description">
                <p>${g.description}</p>
            </div>

            <div class="group-session">
                ${
                    g.session === 1
                    ? `<h3><span style="color:red;">Voting session:</span> <span style="color:black;">${g.x} - ${g.y}</span></h3>`
                    : `<h3><span style="color:red;">No voting session</span></h3>`
                }
            </div>
        </div>
    </div>`;
}

function renderGroups(filter) {
    let container = document.getElementById("groups-container");
    container.innerHTML = "";

    groups
        .filter(g => filter === "all" || g.rumpun === filter)
        .forEach(g => {
            let wrapper = document.createElement("div");
            wrapper.innerHTML = createGroupCard(g);
            container.appendChild(wrapper.firstElementChild);
        });
}

document.getElementById("filter-rumpun").addEventListener("change", function() {
    renderGroups(this.value);
});

// Initial load
renderGroups("all");

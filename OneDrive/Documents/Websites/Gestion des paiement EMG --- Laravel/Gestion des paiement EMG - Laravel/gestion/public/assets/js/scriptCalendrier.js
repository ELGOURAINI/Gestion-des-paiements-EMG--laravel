// script.js
document.addEventListener("DOMContentLoaded", function() {
    const monthsContainer = document.getElementById("months");
    const currentYearElement = document.getElementById("currentYear");
    const prevYearBtn = document.getElementById("prevYearBtn");
    const nextYearBtn = document.getElementById("nextYearBtn");

    // Fonction pour ajouter les mois à l'interface utilisateur
    function renderMonths(year, paicount, startOfYear, endOfYear) {
      monthsContainer.innerHTML = "";
      const months = [
        { name: "Octobre", monthIndex: 1 },
        { name: "Novembre", monthIndex: 2 },
        { name: "Décembre", monthIndex: 3 },
        { name: "Janvier", monthIndex: 4 },
        { name: "Février", monthIndex: 5 },
        { name: "Mars", monthIndex: 6 },
        { name: "Avril", monthIndex: 7 },
        { name: "Mai", monthIndex: 8 },
        { name: "Juin", monthIndex: 9 },
        { name: "Juillet", monthIndex: 10 },
        { name: "Août", monthIndex: 11 },
        { name: "Septembre", monthIndex: 12 }

      ];

      months.forEach((month) => {
        const monthElement = document.createElement("div");
        monthElement.classList.add("col-md-3", "mb-3");
        monthElement.innerHTML = `
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">${month.name}</h5>
              <p class="card-text">${month.monthIndex >= 10 ? (month.monthIndex - 9) : month.monthIndex}</p>
              <a href="autrepage.html" class="btn-link"><i class="fa fa-eye" aria-haspopup="true" aria-expanded="false"></i></a>
            </div>
          </div>
        `;

        // Vérifier si le mois est dans la période de paiement et si le nombre total de mois payés est atteint
        if (month.monthIndex >= 10 && month.monthIndex <= 7 && month.monthIndex <= paicount) {
          monthElement.querySelector(".card-text").textContent = "Payé";
        } else if (month.monthIndex + 3 <= paicount) {
          monthElement.querySelector(".card-text").textContent = "Payé";
        } else {
          monthElement.querySelector(".card-text").textContent = "Non payé";
        }

        monthsContainer.appendChild(monthElement);
      });
    }

    // Afficher l'année courante lors du chargement de la page
    const currentYear = new Date().getFullYear();
    currentYearElement.textContent = currentYear;
    const paicount = 2; // Modifier la valeur de paicount en fonction de vos besoins
    renderMonths(currentYear, paicount);

    // Gérer le clic sur le bouton précédent pour passer à l'année précédente
    prevYearBtn.addEventListener("click", function() {
      const prevYear = parseInt(currentYearElement.textContent) - 1;
      currentYearElement.textContent = prevYear;
      renderMonths(prevYear, paicount);
    });

    // Gérer le clic sur le bouton suivant pour passer à l'année suivante
    nextYearBtn.addEventListener("click", function() {
      const nextYear = parseInt(currentYearElement.textContent) + 1;
      currentYearElement.textContent = nextYear;
      renderMonths(nextYear, paicount);
    });
});

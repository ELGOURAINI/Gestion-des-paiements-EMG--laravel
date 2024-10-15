// index.js
document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.getElementById('nameInput');
    const ageInput = document.getElementById('ageInput');
    const languageInput = document.getElementById('languageInput');
    const filterButton = document.getElementById('filterButton');
    const filteredResults = document.getElementById('filteredResults');

    // Sample data (you can replace this with your own data)
    const developers = [
        { name: 'Kingsley', age: 32, language: 'JavaScript' },
        // ... other developer objects ...
    ];

    // Function to filter results based on user input
    function filterResults() {
        const nameFilter = nameInput.value.toLowerCase();
        const ageFilter = ageInput.value.toLowerCase();
        const languageFilter = languageInput.value.toLowerCase();

        const filteredDevs = developers.filter(dev => {
            return dev.name.toLowerCase().includes(nameFilter) &&
                dev.age.toString().includes(ageFilter) &&
                dev.language.toLowerCase().includes(languageFilter);
        });

        // Display filtered results
        filteredResults.innerHTML = '';
        filteredDevs.forEach(dev => {
            const li = document.createElement('li');
            li.textContent = `${dev.name} (${dev.age} years old, ${dev.language})`;
            filteredResults.appendChild(li);
        });
    }

    // Event listener for the filter button
    filterButton.addEventListener('click', filterResults);
});

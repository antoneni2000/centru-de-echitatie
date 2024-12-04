let currentLanguage = localStorage.getItem('language') || 'ro';
function loadTranslations(language) {
    const translationFile = `js/translations_${language}.json`; 

    fetch(translationFile)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Failed to load translations for language: ${language}`);
            }
            return response.json();
        })
        .then(translations => {
            console.log(translations); 
            applyTranslations(translations);
        })
        .catch(error => {
            console.error("Error loading translations:", error);
        });
}


function applyTranslations(translations) {
    Object.keys(translations).forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.innerHTML = translations[id]; 
        }
    });
}


document.addEventListener('DOMContentLoaded', () => {
    let defaultLanguage = localStorage.getItem('language');
    
    if (!defaultLanguage) {
        defaultLanguage = 'ro'; 
        localStorage.setItem('language', defaultLanguage); 
    }

    loadTranslations(defaultLanguage);
});

document.getElementById('language-selector').addEventListener('change', (event) => {
    const selectedLanguage = event.target.value;
    localStorage.setItem('language', selectedLanguage); 
    loadTranslations(selectedLanguage);
});

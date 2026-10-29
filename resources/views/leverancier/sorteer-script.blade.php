<script>
    // Sorteert elke tabel met de class "sorteerbaar" wanneer op een sorteerknop wordt geklikt
    document.querySelectorAll('table.sorteerbaar').forEach(function (tabel) {
        var tbody = tabel.querySelector('tbody');
        var knoppen = tabel.querySelectorAll('.sorteer-knop');

        knoppen.forEach(function (knop) {
            knop.addEventListener('click', function () {
                var kolom = parseInt(knop.dataset.kolom, 10); // welke kolom (0 = eerste)
                var type = knop.dataset.type;                 // tekst, getal of datum

                // Was deze kolom al oplopend gesorteerd? Dan nu aflopend, anders oplopend
                var oplopend = knop.dataset.richting !== 'oplopend';

                // Zet alle knoppen terug naar het neutrale pijltje
                knoppen.forEach(function (k) {
                    k.dataset.richting = '';
                    k.querySelector('.pijl').textContent = '⇅';
                });

                // Zet de gekozen richting op de aangeklikte knop
                knop.dataset.richting = oplopend ? 'oplopend' : 'aflopend';
                knop.querySelector('.pijl').textContent = oplopend ? '▲' : '▼';

                // Haal alle rijen op en sorteer ze
                var rijen = Array.from(tbody.querySelectorAll('tr'));

                rijen.sort(function (a, b) {
                    var celA = a.children[kolom];
                    var celB = b.children[kolom];

                    // Gebruik data-waarde als die er is, anders de zichtbare tekst
                    var waardeA = celA.dataset.waarde !== undefined ? celA.dataset.waarde : celA.textContent.trim();
                    var waardeB = celB.dataset.waarde !== undefined ? celB.dataset.waarde : celB.textContent.trim();

                    var uitkomst;

                    if (type === 'getal') {
                        // Lege waarden (NULL) tellen als de laagste waarde
                        var getalA = parseFloat(waardeA);
                        var getalB = parseFloat(waardeB);
                        if (isNaN(getalA)) { getalA = -Infinity; }
                        if (isNaN(getalB)) { getalB = -Infinity; }
                        uitkomst = getalA === getalB ? 0 : (getalA < getalB ? -1 : 1);
                    } else if (type === 'datum') {
                        // Datums staan als JJJJ-MM-DD, dus tekst vergelijken werkt goed
                        uitkomst = waardeA.localeCompare(waardeB);
                    } else {
                        // Tekst, hoofdletters maken niet uit
                        uitkomst = waardeA.localeCompare(waardeB, 'nl', { sensitivity: 'base' });
                    }

                    return oplopend ? uitkomst : -uitkomst;
                });

                // Zet de gesorteerde rijen terug in de tabel
                rijen.forEach(function (rij) {
                    tbody.appendChild(rij);
                });
            });
        });
    });
</script>
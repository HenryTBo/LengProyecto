// JS/script.js

document.addEventListener('DOMContentLoaded', function () {
    // --- Código común para todas las páginas ---
    const currentYearElem = document.getElementById('currentYear');
    if (currentYearElem) {
        currentYearElem.textContent = new Date().getFullYear();
    }
    
    markActiveNavLink(); // Marcar enlace activo en la navegación principal
    initFormValidation(); // Activar validación para todos los formularios que la necesiten
    initCarousels(); // Inicializar carruseles si los hay

    // --- Código específico para la página de PRODUCTOS ---
    const productListPageContainer = document.getElementById('productList');
    if (productListPageContainer) { 
        initProductsPage(); // Función separada para la lógica de la página de productos
    }
});

// Marcar el enlace activo en la navegación principal
function markActiveNavLink() {
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    navLinks.forEach(link => {
        const linkPage = link.getAttribute('href').split('/').pop();
        if (linkPage === currentPage) {
            link.classList.add('active');
            link.setAttribute('aria-current', 'page');
        } else {
            link.classList.remove('active');
            link.removeAttribute('aria-current');
        }
    });
}

// Inicialización de la lógica de la página de productos
function initProductsPage() {
    const productListPageContainer = document.getElementById('productList');
    const searchInput = document.getElementById('productSearchInput');
    const searchButton = document.getElementById('searchButton');
    const categoryButtonsContainer = document.getElementById('categoryButtons');
    const noResultsMessage = document.getElementById('noResultsMessage');
    let currentCategory = ""; 

    const products = [
        // RESPIRATORIA
        { id: 1, name: "SALBUTÍN", description: "Suspensión en aerosol para inhalación oral. Herramienta terapéutica para asma y EPOC. 200 dosis.", category: "RESPIRATORIA", image: "images/Productos/RESPIRATORIA/Salbutin.jpg", detailsLink: "Productos-HTML/detalle-salbutin-aerosol.html" },
        { id: 2, name: "AFTOTEX", description: "Solución y spray para infecciones menores de la cavidad bucal (estomatitis, faringitis, aftas). Triple acción.", category: "RESPIRATORIA", image: "images/Productos/RESPIRATORIA/AFTOTEX.png", detailsLink: "Productos-HTML/detalle-aftotex.html" },
        { id: 3, name: "OTOCERUM", description: "Solución ótica en gotas para suavizar y remover el cerumen del oído.", category: "RESPIRATORIA", image: "images/Productos/RESPIRATORIA/otocerum650.png", detailsLink: "Productos-HTML/detalle-otocerum.html" },
        { id: 4, name: "HERBATOS", description: "Expectorante, mucolítico y antitusígeno (Hedera Helix). Coadyuvante en procesos respiratorios.", category: "RESPIRATORIA", image: "images/Productos/RESPIRATORIA/Herbatos Jarabe.jpg", detailsLink: "Productos-HTML/detalle-herbatos-jarabe.html" },
        { id: 6, name: "HERBATOS JENGIBRE", description: "Expectorante, mucolítico y antitusígeno con jengibre. Antiinflamatorio natural, evita congestión.", category: "RESPIRATORIA", image: "images/Productos/RESPIRATORIA/herbatos_jengibre.png", detailsLink: "Productos-HTML/detalle-herbatos-jarabe-jengibre.html" },
        { id: 7, name: "AQUA NASAL", description: "Solución en spray de Cloruro de Sodio al 0.9% para descongestión y limpieza de fosas nasales.", category: "RESPIRATORIA", image: "images/Productos/RESPIRATORIA/aqua_nasal_producto.png", detailsLink: "Productos-HTML/detalle-aqua-nasal.html" },
        { id: 8, name: "AQUA NASAL PEDIÁTRICO", description: "Solución en spray de Cloruro de Sodio al 0.9% para descongestión y limpieza de fosas nasales en niños.", category: "RESPIRATORIA", image: "images/Productos/RESPIRATORIA/AQUA_NASAL PEDIATRICO.png", detailsLink: "Productos-HTML/detalle-aqua-nasal-pediatrico.html" },
        // DESINFECCIÓN DE ALTO NIVEL
        { id: 9, name: "ORTOFTALDEHÍDO SOLUCIÓN", description: "Solución desinfectante al 0.55% para aparatos médicos sensibles al calor. Inmersión de 5 minutos.", category: "DESINFECCIÓN DE ALTO NIVEL", image: "images/Productos/opa2.png", detailsLink: "Productos-HTML/detalle-ortoftaldehido-solucion.html" },
        { id: 10, name: "TIRAS REACTIVAS AL ORTOFTALDEHÍDO", description: "Indicadores químicos para determinar si la concentración de ortoftaldehído está por encima de la MEC de 0.30%.", category: "DESINFECCIÓN DE ALTO NIVEL", image: "images/Productos/DESINFECCIÓN DE ALTO NIVEL/Tiras_650.jpg", detailsLink: "Productos-HTML/detalle-tiras-reactivas.html" },
        // ANTIPARASITARIO
        { id: 11, name: "DELIX", description: "Antiparasitario de amplio espectro con sabor a vainilla. Para lombrices y Giardia Lamblia. Sachet caja x12.", category: "ANTIPARASITARIO", image: "images/Productos/ANTIPARASITARIO/delix.png", detailsLink: "Productos-HTML/detalle-delix.html" },
        { id: 12, name: "PIOFÍN CHAMPÚ", description: "Altamente eficaz contra piojos y liendres, inofensivo para el ser humano. Uso externo. Frasco 100 ml.", category: "ANTIPARASITARIO", image: "images/Productos/ANTIPARASITARIO/piofin.jpg", detailsLink: "Productos-HTML/detalle-piofin-champu.html" },
        { id: 13, name: "PIOFÍN PLUS SOLUCIÓN", description: "Elimina en minutos piojos del cabello, cuerpo y pubis, y sus liendres. Incluye peine. Frasco 60 ml.", category: "ANTIPARASITARIO", image: "images/Productos/ANTIPARASITARIO/Piofin solucion.png", detailsLink: "Productos-HTML/detalle-piofin-plus.html" },
        { id: 14, name: "IVERPIOFÍN", description: "Altamente eficaz contra piojos y liendres. Ivermectina 6mg tabletas, antihelmíntico y ectoparasiticida oral.", category: "ANTIPARASITARIO", image: "images/Productos/ANTIPARASITARIO/iverpiofin.png", detailsLink: "Productos-HTML/detalle-iver-piofin.html" },
        // CARDIOMETABOLICO
        { id: 15, name: "DIABECONTROL", description: "Dapagliflozina 10 mg. Tabletas para diabetes mellitus tipo 2 e insuficiencia cardíaca crónica.", category: "CARDIOMETABOLICO", image: "images/Productos/CARDIOMETABOLICO/Diabecontrol.jpg", detailsLink: "Productos-HTML/detalle-diabecontrol.html" },
        // DERMATOLÓGICO
        { id: 16, name: "TROFODERMAX SPRAY", description: "Spray antiinfeccioso cicatrizante para úlceras cutáneas, infecciones, quemaduras y heridas.", category: "DERMATOLÓGICO", image: "images/Productos/DERMATOLÓGICO/TROFODERMAX SPRAY.png", detailsLink: "Productos-HTML/detalle-trofodermax-spray.html" },
        { id: 17, name: "FUSIBIOTIC", description: "Crema antibiótica para infecciones de la piel como heridas infectadas, granos y acné. Uso externo.", category: "DERMATOLÓGICO", image: "images/Productos/DERMATOLÓGICO/fusibiotic.png", detailsLink: "Productos-HTML/detalle-fusibiotic.html" },
        { id: 18, name: "ALERGEL", description: "Gel para alergias, picaduras, quemaduras solares e irritaciones. Transparente, sin olor, no grasoso.", category: "DERMATOLÓGICO", image: "images/Productos/DERMATOLÓGICO/ALERGEL_nueva.png", detailsLink: "Productos-HTML/detalle-alergel.html" },
        { id: 19, name: "TERMINAFÍN CREMA", description: "Alivia picazón, ardor y descamación por hongos. Antimicótico para pie de atleta, tiña, candidiasis.", category: "DERMATOLÓGICO", image: "images/Productos/DERMATOLÓGICO/Terminafin crema.png", detailsLink: "Productos-HTML/detalle-terminafin-crema.html" },
        { id: 20, name: "SECARIDE SPRAY", description: "Formulación para curación de heridas y lesiones exudativas con riesgo de infección. Con Zeolita de plata.", category: "DERMATOLÓGICO", image: "images/Productos/DERMATOLÓGICO/Secaride Spray.jpg", detailsLink: "Productos-HTML/detalle-secaride-spray.html" },
        { id: 21, name: "DERMETIQUE DESODORANTE EN CREMA", description: "Desodorante y antitranspirante en crema. Disminuye transpiración y olor por 24 horas. No irritante.", category: "DERMATOLÓGICO", image: "images/Productos/DERMATOLÓGICO/Dermetique50ml_desodorante_crema.png", detailsLink: "Productos-HTML/detalle-dermetique.html" },
        { id: 22, name: "TERMINAFÍN SPRAY 30ml.", description: "Alivia picazón y síntomas de hongos. Terbinafina, antimicótico de amplio espectro.", category: "DERMATOLÓGICO", image: "images/Productos/DERMATOLÓGICO/Terminafin 30 ml.png", detailsLink: "Productos-HTML/detalle-terminafin-spray-30ml.html" },
        { id: 23, name: "TERMINAFIN SPRAY 125 ML", description: "Alivia picazón y síntomas de hongos. Terbinafina, antimicótico. Presentación grande.", category: "DERMATOLÓGICO", image: "images/Productos/DERMATOLÓGICO/Terminafin 125 ml.png", detailsLink: "Productos-HTML/detalle-terminafin-spray-125ml.html" },
        { id: 24, name: "SECARIDE JABON NEUTRO", description: "Jabón en espuma efectivo para limpieza de heridas y lesiones sin irritación. Con Lauril Sulfato de Sodio.", category: "DERMATOLÓGICO", image: "images/Productos/DERMATOLÓGICO/Secaride Jabon.jpg", detailsLink: "Productos-HTML/detalle-secaride-jabon.html" },
        { id: 25, name: "TROFODERMAX CREMA", description: "Crema Clostebol-Neomicina para úlceras cutáneas, infecciones, quemaduras y heridas. Cicatrizante.", category: "DERMATOLÓGICO", image: "images/Productos/DERMATOLÓGICO/Trofodermax Crema.jpg", detailsLink: "Productos-HTML/detalle-trofodermax-crema.html" },
        { id: 26, name: "MEDIGLOSS", description: "Ungüento para humectar la piel del bebé en la zona del pañal. Enriquecido con D-Pantenol.", category: "DERMATOLÓGICO", image: "images/Productos/DERMATOLÓGICO/medigloss_producto.png", detailsLink: "Productos-HTML/detalle-medigloss.html" },
        { id: 28, name: "BIOPANTENOL UNGÜENTO", description: "Ungüento hipoalergénico enriquecido con D-Pantenol para el cuidado de la piel.", category: "DERMATOLÓGICO", image: "images/Productos/DERMATOLÓGICO/BioPantenol_unguento_productoycaja.jpg", detailsLink: "Productos-HTML/detalle-biopantenol-UNGÜENTO.html" },
        { id: 50, name: "BIOPANTENOL CREMA", description: "Crema hipoalergénica enriquecida con D-Pantenol para humectar la piel del bebé en la zona del pañal. Presentación: tubo de 50g. Uso tópico.", category: "DERMATOLÓGICO", image: "images/Productos/DERMATOLÓGICO/BioPantenol_crema_productoycaja.jpg", detailsLink: "Productos-HTML/detalle-biopantenol-crema.html" },
        // DOLOR
        { id: 29, name: "AZ MINOFÉN", description: "Analgésico y antipirético con sabor a fresa-cereza. Tratamiento de fiebre y dolores leves. Solución.", category: "DOLOR", image: "images/Productos/DOLOR/az.png", detailsLink: "Productos-HTML/detalle-az-minofen.html" },
        { id: 30, name: "LIDOCAÍNA SPRAY PRESURIZADA", description: "Anestésico local tópico al 10% para piel, cirugía menor, y alivio de quemaduras o picaduras.", category: "DOLOR", image: "images/Productos/DOLOR/Lidocana_650.png", detailsLink: "Productos-HTML/detalle-lidocaina-spray.html" },
        { id: 31, name: "SPORT ICE", description: "Spray para alivio inmediato del dolor por enfriamiento (terapia en frío). Efecto analgésico y antiinflamatorio.", category: "DOLOR", image: "images/Productos/DOLOR/sportice.png", detailsLink: "Productos-HTML/detalle-sport-ice.html" },
        { id: 32, name: "GOLPARÉN", description: "Diclofenaco dietilamina 1.16%. Reduce inflamación y alivia dolor en golpes, torceduras, dolores musculares.", category: "DOLOR", image: "images/Productos/DOLOR/golparen.png", detailsLink: "Productos-HTML/detalle-golparen.html" },
        { id: 33, name: "FLEXITAB", description: "Ciclobenzaprina Clorhidrato 10 mg. Tabletas para alivio del espasmo muscular y dolor agudo.", category: "DOLOR", image: "images/Productos/DOLOR/Flexitab.jpg", detailsLink: "Productos-HTML/detalle-flexitab.html" },
        { id: 34, name: "ROLOMED", description: "Ibuprofeno 50 mg/g gel. Analgésico y antiinflamatorio local para dolor leve a moderado en tejidos blandos.", category: "DOLOR", image: "images/Productos/DOLOR/rolomed.png", detailsLink: "Productos-HTML/detalle-rolomed.html" },
        { id: 35, name: "MEGALIVIA", description: "Dexketoprofeno 25 mg. Solución oral en sachet para tratamiento sintomático del dolor agudo leve o moderado.", category: "DOLOR", image: "images/Productos/DOLOR/Megalivia.png", detailsLink: "Productos-HTML/detalle-megalivia.html" },
        { id: 51, name: "MEGALIVIA TABLETAS", description: "Dexketoprofeno 25 mg. Tabletas recubiertas para tratamiento sintomático del dolor leve a moderado..", category: "DOLOR", image: "images/Productos/DOLOR/megalivia_01.jpg", detailsLink: "Productos-HTML/detalle-megalivia-tabletas.html" },
        // GASTRICO
        { id: 36, name: "FRUTADEX ADULTO Y NIÑOS", description: "Suero de rehidratación oral, \"el suero que sí sabe bien\". Para recuperar electrolitos en diarrea, vómito, calor.", category: "GASTRICO", image: "images/Productos/GASTRICO/Frutadex Familia.png", detailsLink: "Productos-HTML/detalle-frutadex.html" },
        { id: 37, name: "DIABEDEX", description: "Bebida hidratante hipotónica sin calorías con electrolitos para evitar síntomas de deshidratación.", category: "GASTRICO", image: "images/Productos/GASTRICO/Diabedex.png", detailsLink: "Productos-HTML/detalle-diabedex.html" },
        { id: 38, name: "BUCO VAC", description: "Sobres dispersables con probióticos para mejorar el balance de la flora intestinal.", category: "GASTRICO", image: "images/Productos/GASTRICO/Buco Vac.jpg", detailsLink: "Productos-HTML/detalle-bucovac.html" },
        { id: 39, name: "YDRAT", description: "YDRAT® Zn 60. Bebida hidratante con Zinc y electrolitos. Sabores: Arándano, Frutos Rojos, Kiwi, Maracuyá.", category: "GASTRICO", image: "images/Productos/GASTRICO/ydrat familia.png", detailsLink: "Productos-HTML/detalle-ydrat.html" },
        { id: 40, name: "LIVIOSAN", description: "Tratamiento integral para Síndrome de Intestino Irritable. Bromuro de Pinaverio y Simeticona.", category: "GASTRICO", image: "images/Productos/GASTRICO/liviosanlateral.jpg", detailsLink: "Productos-HTML/detalle-liviosan.html" },
        // OTC
        { id: 41, name: "LUBRISEX", description: "Lubricante íntimo a base de agua. Seguro, discreto, no grasoso, transparente. Tubo 50g y Sachet 10g.", category: "OTC", image: "images/Productos/OTC/LubriSex Gel.jpg", detailsLink: "Productos-HTML/detalle-lubrisex.html" },
        { id: 42, name: "SPIN DESODORANTE", description: "Antitranspirante roll-on sin perfume, con bactericida. Ideal para sudoración fuerte y pieles sensibles. 90ml.", category: "OTC", image: "images/Productos/OTC/Spin_MyH.png", detailsLink: "Productos-HTML/detalle-spin-desodorante.html" },
        { id: 43, name: "DURASEX", description: "Spray con Lidocaína al 10% para controlar la sensibilidad del pene y retardar la eyaculación. Spray 9ml.", category: "OTC", image: "images/Productos/OTC/Dura Sex Spray.jpg", detailsLink: "Productos-HTML/detalle-durasex.html" },
        { id: 45, name: "CICLOPIROX", description: "Solución tópica al 8% para el tratamiento de infecciones de las uñas causadas por hongos. Frasco 5g.", category: "OTC", image: "images/Productos/OTC/Ciclo-P.jpg", detailsLink: "Productos-HTML/detalle-ciclopirox.html" },
        // UROLÓGICO
        { id: 48, name: "MEDIGRAY UROBLU", description: "Extracto de arándano rojo (cranberry) para profilaxis y coadyuvante en tratamiento de infecciones del tracto urinario inferior.", category: "UROLÓGICO", image: "images/Productos/UROLÓGICO/Uroblu650.png", detailsLink: "Productos-HTML/detalle-uroblu.html" },
        { id: 49, name: "Medigray Vigor", description: "Suplemento nutricional en sachets bebibles con Aspartato de Arginina 5g/10 mL.", category: "UROLÓGICO", image: "images/Productos/UROLÓGICO/Vigor 650.png", detailsLink: "Productos-HTML/detalle-vigor.html" }

    ];

    // *** CAMBIO REALIZADO AQUÍ: Ordenar productos alfabéticamente por nombre ***
    products.sort((a, b) => a.name.localeCompare(b.name));

    if (categoryButtonsContainer) {
        const categoriesInOrder = ["TODOS", "RESPIRATORIA", "DESINFECCIÓN DE ALTO NIVEL", "UROLÓGICO", "CARDIOMETABOLICO", "DOLOR", "OTC", "ANTIPARASITARIO", "GASTRICO", "DERMATOLÓGICO", "OTROS"];
        
        categoriesInOrder.forEach(category => {
            const button = document.createElement('button');
            if (category === "TODOS" || products.some(p => p.category === category)) {
                button.classList.add('btn', 'btn-outline-primary', 'category-button', 'me-2', 'mb-2');
                button.textContent = category.replace(/_/g, " ");
                button.setAttribute('data-category', category === "TODOS" ? "" : category);
                categoryButtonsContainer.appendChild(button);

                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    currentCategory = this.getAttribute('data-category');
                    updateURLAndFilter();
                });
            }
        });
    }

    function renderProducts(productsToRender) {
        if (!productListPageContainer) return; 
        productListPageContainer.innerHTML = ''; 
        if (noResultsMessage) noResultsMessage.style.display = 'none';

        if (productsToRender.length === 0) {
            if (noResultsMessage) noResultsMessage.style.display = 'block';
            return;
        }

        productsToRender.forEach(product => {
            // *** CAMBIO CLAVE 1: Añadir la categoría a la URL del producto ***
            const categoryQueryParam = currentCategory ? `?cat=${encodeURIComponent(currentCategory)}` : '';
            const finalDetailLink = `${product.detailsLink}${categoryQueryParam}`;

            const productCardHTML = `
                <div class="col-md-6 col-lg-4 mb-4"> 
                    <div class="card product-card shadow-sm h-100">
                        <div class="product-img-container">
                            <img src="${product.image}" alt="${product.name}" class="img-fluid">
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <span class="product-category">${product.category.replace(/_/g, " ")}</span>
                            <h3 class="product-title mt-2">${product.name}</h3>
                            <p class="product-description flex-grow-1">${product.description.substring(0, 70)}${product.description.length > 70 ? '...' : ''}</p>
                            <a href="${finalDetailLink}" class="btn btn-product-detail mt-auto align-self-center">
                                <i class="bi bi-eye me-2"></i>Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            `;
            productListPageContainer.insertAdjacentHTML('beforeend', productCardHTML);
        });
    }

    function filterAndRender() {
        if (!productListPageContainer) return; 
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : "";
        let filteredProducts = products;

        if (currentCategory) {
            filteredProducts = filteredProducts.filter(product => product.category === currentCategory);
        }

        if (searchTerm) {
            filteredProducts = filteredProducts.filter(product =>
                product.name.toLowerCase().includes(searchTerm) ||
                product.description.toLowerCase().includes(searchTerm) ||
                product.category.toLowerCase().replace(/_/g, " ").includes(searchTerm)
            );
        }

        // Marcar el botón de categoría activo
        document.querySelectorAll('#categoryButtons .category-button').forEach(btn => {
            if (btn.getAttribute('data-category') === currentCategory) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        renderProducts(filteredProducts);
    }
    
    // *** CAMBIO CLAVE 2: Nueva función para actualizar la URL sin recargar la página ***
    function updateURLAndFilter() {
        const url = new URL(window.location);
        const params = url.searchParams;
        const searchTerm = searchInput ? searchInput.value.trim() : "";

        if (currentCategory) {
            params.set('cat', currentCategory);
        } else {
            params.delete('cat');
        }
        if (searchTerm) {
            params.set('search', searchTerm);
        } else {
            params.delete('search');
        }

        // history.pushState nos permite cambiar la URL en la barra de direcciones
        // para que el botón "atrás" del navegador funcione correctamente.
        history.pushState({category: currentCategory}, '', url);
        filterAndRender();
    }

    if (searchInput) {
        searchInput.addEventListener('input', updateURLAndFilter);
    }
    if (searchButton) {
        searchButton.addEventListener('click', updateURLAndFilter);
    }
    
    // *** CAMBIO CLAVE 3: Leer los parámetros de la URL al cargar la página ***
    function initializeFiltersFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        const catParam = urlParams.get('cat');
        const searchParam = urlParams.get('search');

        if (catParam) {
            currentCategory = catParam;
        }
        if (searchInput && searchParam){
             searchInput.value = decodeURIComponent(searchParam);
        }

        filterAndRender(); 
    }
    
    // Escuchar el evento 'popstate' que se dispara con el botón "atrás/adelante" del navegador
    window.addEventListener('popstate', initializeFiltersFromURL);
    
    // Carga inicial
    initializeFiltersFromURL();
}

// Inicialización de formularios con validación
function initFormValidation() {
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                event.preventDefault(); 
                alert('Formulario enviado correctamente. Gracias.');
                form.reset();
                form.classList.remove('was-validated');
            }
            form.classList.add('was-validated');
        }, false);
    });
}

// Función para inicializar carruseles si existen
function initCarousels() {
    const carousels = document.querySelectorAll('.carousel');
    carousels.forEach(carousel => {
        new bootstrap.Carousel(carousel);
    });
}
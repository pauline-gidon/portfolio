    //la fonction de rappel onGoogleReCaptchaApiLoad() 
    function onGoogleReCaptchaApiLoad() {
        let widgets = document.querySelectorAll('[data-toggle="recaptcha"]');
        for (let i = 0; i < widgets.length; i++) {
            renderReCaptcha(widgets[i]);
        }
    }

// // alert('{{ gg_recaptcha_site_key }}');
// let key = '{{ gg_recaptcha_site_key }}';
// alert(key);
    // Rendre le widget donné en tant que reCAPTCHA à partir de l'attribut data-type
    function renderReCaptcha(widget) {
        let form = widget.closest('form');
        let widgetType = widget.getAttribute('data-type');
        let widgetParameters = {
            'sitekey': '6LcQAPgcAAAAAO3KS4UW3nonog1cU3J5EhniwsmM'
        };

        if (widgetType == 'invisible') {
            widgetParameters['callback'] = function () {
                form.submit()
            };
            widgetParameters['size'] = "invisible";
        }

        let widgetId = grecaptcha.render(widget, widgetParameters);

        if (widgetType == 'invisible') {
            bindChallengeToSubmitButtons(form, widgetId);
        }
    }

        // empecher la soumission du formulaire
        function bindChallengeToSubmitButtons(form, reCaptchaId) {
            getSubmitButtons(form).forEach(function (button) {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    grecaptcha.execute(reCaptchaId);
                });
            });
        }
        

        // Obtenez les boutons d'envoi du formulaire donné
        
        function getSubmitButtons(form) {
            let buttons = form.querySelectorAll('button, input');
            let submitButtons = [];
        
            for (let i= 0; i < buttons.length; i++) {
                let button = buttons[i];
                if (button.getAttribute('type') == 'submit') {
                    submitButtons.push(button);
                }
            }
        
            return submitButtons;
        } 


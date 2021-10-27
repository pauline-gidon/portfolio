        
        // empecher la soumission du formulaire
        function bindChallengeToSubmitButtons(form, reCaptchaId) {
            getSubmitButtons(form).forEach(function (button) {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    grecaptcha.execute(reCaptchaId);
                });
            });
        }
        
        //la fonction de rappel onGoogleReCaptchaApiLoad() 
        function onGoogleReCaptchaApiLoad() {
            var widgets = document.querySelectorAll('[data-toggle="recaptcha"]');
            for (var i = 0; i < widgets.length; i++) {
                renderReCaptcha(widgets[i]);
            }
        }


        // Rendre le widget donné en tant que reCAPTCHA à partir de l'attribut data-type
        function renderReCaptcha(widget) {
            var form = widget.closest('form');
            var widgetType = widget.getAttribute('data-type');
            var widgetParameters = {
                'sitekey': '{{ gg_recaptcha_site_key }}'
            };

            if (widgetType == 'invisible') {
                widgetParameters['callback'] = function () {
                    form.submit()
                };
                widgetParameters['size'] = "invisible";
            }

            var widgetId = grecaptcha.render(widget, widgetParameters);

            if (widgetType == 'invisible') {
                bindChallengeToSubmitButtons(form, widgetId);
            }
        }




        // Obtenez les boutons d'envoi du formulaire donné
        
        function getSubmitButtons(form) {
            var buttons = form.querySelectorAll('button, input');
            var submitButtons = [];
        
            for (var i= 0; i < buttons.length; i++) {
                var button = buttons[i];
                if (button.getAttribute('type') == 'submit') {
                    submitButtons.push(button);
                }
            }
        
            return submitButtons;
        } 


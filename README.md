Oauth + Restful API + Symfony 3
=======


Add this to composer.json with minimun stability

    ...

    "jms/serializer-bundle": "dev-master",
    "friendsofsymfony/rest-bundle": "^2.2",
    "friendsofsymfony/oauth-server-bundle": "dev-master"
    "sebardo/admin": "dev-master",
    ...


Example of configuration file config.yml for this project


    imports:
        - { resource: parameters.yml }
        - { resource: services.yml }
        - { resource: "@ApiBundle/Resources/config/security.yml" }
        - { resource: "@CoreBundle/Resources/config/services.yml" }
        - { resource: "@AdminBundle/Resources/config/services.yml" }

    # Put parameters here that don't need to change on each machine where the app is deployed
    # https://symfony.com/doc/current/best_practices/configuration.html#application-related-configuration
    parameters:
        locale: en

    framework:
        #esi: ~
        translator: { fallbacks: ['%locale%'] }
        secret: '%secret%'
        router:
            resource: '%kernel.project_dir%/app/config/routing.yml'
            strict_requirements: ~
        form: ~
        csrf_protection: ~
        validation: { enable_annotations: true }
        serializer: { enable_annotations: true }
        templating:
            engines: ['twig']
        default_locale: '%locale%'
        trusted_hosts: ~
        session:
            # https://symfony.com/doc/current/reference/configuration/framework.html#handler-id
            handler_id: session.handler.native_file
            save_path: '%kernel.project_dir%/var/sessions/%kernel.environment%'
        fragments: ~
        http_method_override: true
        assets: ~
        php_errors:
            log: true

    # Twig Configuration
    twig:
        debug: '%kernel.debug%'
        strict_variables: '%kernel.debug%'
        globals:
            core: %core%
            twig_global: "@twig.global"  
    # Doctrine Configuration
    doctrine:
        dbal:
            driver: pdo_mysql
            host: '%database_host%'
            port: '%database_port%'
            dbname: '%database_name%'
            user: '%database_user%'
            password: '%database_password%'
            charset: UTF8
            # if using pdo_sqlite as your database driver:
            #   1. add the path in parameters.yml
            #     e.g. database_path: "%kernel.project_dir%/var/data/data.sqlite"
            #   2. Uncomment database_path in parameters.yml.dist
            #   3. Uncomment next line:
            #path: '%database_path%'

        orm:
            auto_generate_proxy_classes: "%kernel.debug%"
            entity_managers:
                default:
                    naming_strategy: doctrine.orm.naming_strategy.underscore
                    auto_mapping: true
                    # New custom filter
                    filters:
                        oneLocale:
                            class: A2lix\I18nDoctrineBundle\Doctrine\ORM\Filter\OneLocaleFilter
                            enabled: true
                    dql:
                        string_functions: 
                            GROUP_CONCAT: CoreBundle\Functions\GroupConcatFunction
                        datetime_functions:
                            DATE: CoreBundle\Functions\DateFunction
                            DATEFORMAT: CoreBundle\Functions\DateFormatFunction

    # Swiftmailer Configuration
    swiftmailer:
        transport: '%mailer_transport%'
        host: '%mailer_host%'
        username: '%mailer_user%'
        password: '%mailer_password%'
        spool: { type: memory }

    <<<<<<<<<<<<<<<<<<<<<<<<<< here start adding >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    #REST
    sensio_framework_extra:
        view:
            annotations: true

    fos_rest:
        param_fetcher_listener: true
        body_listener: true
        format_listener: true
        view:
            view_response_listener: false
        routing_loader:
            default_format: json
        access_denied_listener:
            json: true
        exception:
            codes:
                'Symfony\Component\Routing\Exception\ResourceNotFoundException': 404
                'Doctrine\ORM\OptimisticLockException': HTTP_CONFLICT
            messages:
                'Symfony\Component\Routing\Exception\ResourceNotFoundException': true

    #OAUTH
    fos_oauth_server:
        db_driver: orm
        client_class:        ApiBundle\Entity\Client
        access_token_class:  ApiBundle\Entity\AccessToken
        refresh_token_class: ApiBundle\Entity\RefreshToken
        auth_code_class:     ApiBundle\Entity\AuthCode
        service:
            options:
                supported_scopes: read

    #CORE 
    # Assetic Configuration
    assetic:
        debug:          "%kernel.debug%"
        use_controller: '%kernel.debug%'
        bundles:
            [ CoreBundle, AdminBundle]
        node: "%node_path%"
        filters:
            cssrewrite:
                apply_to: ".css$"
            less:
                node: "%node_path%"
                node_paths: ["%node_modules_path%"]
                apply_to: ".less$"

    jms_i18n_routing:
        default_locale: en
        locales: [en]
        strategy: prefix_except_default 

    a2lix_i18n_doctrine:
        manager_registry: doctrine       # [1]
    a2lix_translation_form:
        locale_provider: default       # [1]
        locales: [en]      # [1-a]
        default_locale: en             # [1-b]
        required_locales: [en]         # [1-c]
        manager_registry: doctrine     # [2]
        templating: "CoreBundle:Base:default.tabs.html.twig"      # [3]

    # Translation Configuration
    asm_translation_loader:
        driver: orm
        history: true # default false
        database:
            entity_manager: default

    core:
        server_base_url: 'http://rest.dev'
        fixtures_dev: true
        fixtures_test: false
        admin_email: admin@admin.com
    admin:
        admin_menus: ~
        company_menus: ~
        apis: 
            google_analytics:
                options:
                    application_name: Analitycs integración
                    oauth2_client_id: 43533348693-s4rafifpr1o07gja2kgnfbhf4tjq2g0f.apps.googleusercontent.com
                    oauth2_client_secret: lo04F5hvUi_gPaAxyucY70jy
                    oauth2_redirect_uri: 'http://sasturain.dev/admin/analytics'
                    developer_key: AIzaSyCda_bsJ-kEa1M1DJenwKfUfyLVlVKuC6I

    dcs_dynamic_discriminator_map:
        mapping:
            baseactor:
                entity: CoreBundle\Entity\BaseActor
                map:
                    Actor: ApiBundle\Entity\Actor




Add bundles to AppKernel.php

    //rest
    new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
    new JMS\SerializerBundle\JMSSerializerBundle(),
    new FOS\RestBundle\FOSRestBundle(),
    //oauth
    new FOS\OAuthServerBundle\FOSOAuthServerBundle(),
    //core
    new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
    new Symfony\Bundle\AsseticBundle\AsseticBundle(),
    new A2lix\I18nDoctrineBundle\A2lixI18nDoctrineBundle(),
    new A2lix\TranslationFormBundle\A2lixTranslationFormBundle(),
    new Asm\TranslationLoaderBundle\AsmTranslationLoaderBundle(),
    new DCS\DynamicDiscriminatorMapBundle\DCSDynamicDiscriminatorMapBundle(),
    new JMS\I18nRoutingBundle\JMSI18nRoutingBundle(),
    //own
    new CoreBundle\CoreBundle(),
    new AdminBundle\AdminBundle(),
    new ApiBundle\ApiBundle(),


Add route to routing.yml

    core:
        resource: "@CoreBundle/Resources/config/routing.yml"
        prefix:   /

    admin:
        resource: "@AdminBundle/Resources/config/routing.yml"
        prefix:   /

    api:
        resource: "@ApiBundle/Resources/config/routing.yml"
        prefix:   /
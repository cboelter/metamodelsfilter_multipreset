<?php

use MetaModels\Filter\Setting\Events\CreateFilterSettingFactoryEvent;
use MetaModels\MetaModelsEvents;

return array
(
    MetaModelsEvents::FILTER_SETTING_FACTORY_CREATE => array(
        function (CreateFilterSettingFactoryEvent $event) {
            $event->getFactory()->addTypeFactory(new MetaModels\Filter\Setting\MultiPresetFilterSettingTypeFactory());
        }
    )
);

# HR_Converter_bitrix24
 
By using this repository with open PHP code, the author disclaims responsibility for any consequences of its use!

Помощь с новым модулем Bitrix24 humanresources для его переустановки и конвертирования структуры компании в новый модуль.

Используя данный репозиторий с открытым PHP-кодом автор снимает с себя ответственность за какие-либо последствия его использования

Файлы тестировались на 24/25-ой версиях CRM Bitrix24 (business ed.) с базой даных на MySQL

#////////////////////////////////////////

1.	ConverterHR.php 

The file contains the conversion of employees and heads of departments by department (the department block is taken from the iblock3 section and is based on the binding property of the UF_HEADER user field from b_uts_iblock_3_section)

It is relevant for large companies when updating Bitrix24 and the first implementation of the humanrecourses module.

2.	InstallHR.php 

If the module is installed incorrectly, you can manually clean it (as of 01.09.2025, there are no module uninstall actions inside the 25th version of Bitrix24). To do this, delete the humanresources line from b_module; delete the entries from b_module_to_module and b_agent in which the TO_CLASS field starts with the corresponding Bitrix\HumanResources class.\ 

After stripping, expose the module again through the installation of modules. 

A file does the same thing. InstallHR.php

Sergey O.
onsergey@mail.ru

#////////////////////////////////////////

1.	ConverterHR.php 

Файл содержит конверсию сотрудников и глав подразделений по департаментам (блок департаментов берётся из iblock3 section и базируется на связующем свойстве пользовательского поля UF_HEADER из b_uts_iblock_3_section)

Актуально для больших компаний при обновлении Bitrix24 и первом внедрении модуля humanrecourses.

2.	InstallHR.php 

Если модуль некорректно установился можно произвести его ручную зачистку (на 01.09.2025 внутри 25-ой версии Bitrix24 отсутствуют действия деинсталляции модуля). Для этого нужно: удалить строку humanresources из b_module; удалить записи из b_module_to_module  и b_agent в которых поле TO_CLASS начинается с соответствующего класса Bitrix\HumanResources\ 

После зачистки выставить модуль повторно через установку модулей. 

Аналогичные действия делает файл InstallHR.php

Сергей О.
onsergey@mail.ru


/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./inc/classes/block-editor/blocks/movies-block/components/CountControl.js":
/*!*********************************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movies-block/components/CountControl.js ***!
  \*********************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ CountControl; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);




/**
 * Component for controlling the count of movies to display.
 *
 * This component renders an input field for setting the count of movies to display
 * within a specified range (0 - 10).
 *
 * @param {Object}   props          - The properties passed to the CountControl component.
 * @param {Function} props.setCount - A function to set the count of movies.
 * @param {number}   props.count    - The current count of movies.
 * @return {JSX.Element} JSX element representing the count control.
 */
function CountControl({
  setCount,
  count
}) {
  const [randomID] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(Math.floor(Math.random() * 1e5));
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("fieldset", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("legend", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Select Count', 'movie-library')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    htmlFor: `${randomID}_count_input`
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Number of movies (0 - 10)', 'movie-library')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("br", null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("br", null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    type: "number",
    step: 1,
    value: count,
    id: `${randomID}_count_input`,
    onChange: evt => setCount(evt.target.value),
    min: 1,
    max: 10
  })));
}

/***/ }),

/***/ "./inc/classes/block-editor/blocks/movies-block/components/DirectorControl.js":
/*!************************************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movies-block/components/DirectorControl.js ***!
  \************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ DirectorControl; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/html-entities */ "@wordpress/html-entities");
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__);








/**
 * Component for controlling the selection of a movie director.
 *
 * This component renders a ComboboxControl to select a movie director based on
 * available options retrieved from the WordPress database.
 *
 * @param {Object}   props                - The properties passed to the DirectorControl component.
 * @param {Function} props.setDirector    - A function to set the selected movie director.
 * @param {number}   props.directorTermID - The ID of the director term in the database.
 * @param {number}   props.director       - The currently selected director.
 * @return {JSX.Element} JSX element representing the director control.
 */
function DirectorControl({
  setDirector,
  directorTermID,
  director
}) {
  const [options, setOptions] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);
  const [filteredOptions, setFilteredOptions] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);
  const {
    directors,
    haveDirectorsResolved
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useSelect)(select => {
    const query = {
      'mlib-person-career': directorTermID
    };
    const selectorArgs = ['postType', 'mlib-person', query];
    return {
      directors: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_3__.store).getEntityRecords(...selectorArgs),
      haveDirectorsResolved: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_3__.store).hasFinishedResolution('getEntityRecords', selectorArgs)
    };
  }, []);

  // Set up directors list if resolved.
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (!haveDirectorsResolved || !directors) {
      return;
    }
    const directorOptions = directors.map(currDirector => ({
      label: (0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__.decodeEntities)(currDirector.title.rendered),
      value: currDirector.id
    }));
    setOptions([...directorOptions]);
    setFilteredOptions([...directorOptions]);
  }, [haveDirectorsResolved]);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("fieldset", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("legend", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Select Director', 'movie-library')), haveDirectorsResolved && directors ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ComboboxControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Director', 'movie-library'),
    value: director,
    onChange: setDirector,
    options: filteredOptions,
    onFilterValueChange: inputValue => setFilteredOptions(options.filter(option => option.label.toLowerCase().startsWith(inputValue.toLowerCase())))
  }) : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Spinner, null));
}

/***/ }),

/***/ "./inc/classes/block-editor/blocks/movies-block/components/GenreControl.js":
/*!*********************************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movies-block/components/GenreControl.js ***!
  \*********************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ GenreControl; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/html-entities */ "@wordpress/html-entities");
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__);








/**
 * Component for controlling the selection of a movie genre.
 *
 * This component renders a ComboboxControl to select a movie genre based on
 * available options retrieved from the WordPress database.
 *
 * @param {Object}   props          - The properties passed to the GenreControl component.
 * @param {Function} props.setGenre - A function to set the selected movie genre.
 * @param {number}   props.genre    - The currently selected movie genre.
 * @return {JSX.Element} JSX element representing the genre control.
 */
function GenreControl({
  setGenre,
  genre
}) {
  const [options, setOptions] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);
  const [filteredOptions, setFilteredOptions] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);
  const {
    genres,
    haveGenresResolved
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useSelect)(select => {
    const query = {
      per_page: -1
    };
    const selectorArgs = ['taxonomy', 'mlib-movie-genre', query];
    return {
      genres: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_3__.store).getEntityRecords(...selectorArgs),
      haveGenresResolved: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_3__.store).hasFinishedResolution('getEntityRecords', selectorArgs)
    };
  }, []);

  // Set up genre options if resolved.
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (!haveGenresResolved || !genres) {
      return;
    }
    const genreOptions = genres.map(currGenre => ({
      label: (0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__.decodeEntities)(currGenre.name),
      value: currGenre.id
    }));
    setOptions([...genreOptions]);
    setFilteredOptions([...genreOptions]);
  }, [haveGenresResolved]);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("fieldset", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("legend", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Select Genre', 'movie-library')), haveGenresResolved && genres ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ComboboxControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Genre', 'movie-library'),
    value: genre,
    onChange: setGenre,
    options: filteredOptions,
    onFilterValueChange: inputValue => setFilteredOptions(options.filter(option => option.label.toLowerCase().startsWith(inputValue.toLowerCase())))
  }) : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Spinner, null));
}

/***/ }),

/***/ "./inc/classes/block-editor/blocks/movies-block/components/LabelControl.js":
/*!*********************************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movies-block/components/LabelControl.js ***!
  \*********************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ LabelControl; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/html-entities */ "@wordpress/html-entities");
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__);








/**
 * Component for controlling the selection of a movie label.
 *
 * This component renders a ComboboxControl to select a movie label based on
 * available options retrieved from the WordPress database.
 *
 * @param {Object}   props          - The properties passed to the LabelControl component.
 * @param {Function} props.setLabel - A function to set the selected movie label.
 * @param {number}   props.label    - The currently selected movie label.
 * @return {JSX.Element} JSX element representing the label control.
 */

function LabelControl({
  setLabel,
  label
}) {
  const [options, setOptions] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);
  const [filteredOptions, setFilteredOptions] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);
  const {
    labels,
    haveLabelsResolved
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useSelect)(select => {
    const query = {
      per_page: -1
    };
    const selectorArgs = ['taxonomy', 'mlib-movie-label', query];
    return {
      labels: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_3__.store).getEntityRecords(...selectorArgs),
      haveLabelsResolved: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_3__.store).hasFinishedResolution('getEntityRecords', selectorArgs)
    };
  }, []);

  // Set up the options if query resolved.
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (!haveLabelsResolved || !labels) {
      return;
    }
    const labelOptions = labels.map(currLabel => ({
      label: (0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__.decodeEntities)(currLabel.name),
      value: currLabel.id
    }));
    setOptions([...labelOptions]);
    setFilteredOptions([...labelOptions]);
  }, [haveLabelsResolved]);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("fieldset", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("legend", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Select Label', 'movie-library')), haveLabelsResolved && labels ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ComboboxControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Label', 'movie-library'),
    value: label,
    onChange: setLabel,
    options: filteredOptions,
    onFilterValueChange: inputValue => setFilteredOptions(options.filter(option => option.label.toLowerCase().startsWith(inputValue.toLowerCase())))
  }) : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Spinner, null));
}

/***/ }),

/***/ "./inc/classes/block-editor/blocks/movies-block/components/LanguageControl.js":
/*!************************************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movies-block/components/LanguageControl.js ***!
  \************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ LanguageControl; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/html-entities */ "@wordpress/html-entities");
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__);








/**
 * Component for controlling the selection of a movie language.
 *
 * This component renders a ComboboxControl to select a movie language based on
 * available options retrieved from the WordPress database.
 *
 * @param {Object}   props             - The properties passed to the LanguageControl component.
 * @param {Function} props.setLanguage - A function to set the selected movie language.
 * @param {number}   props.language    - The currently selected movie language.
 * @return {JSX.Element} JSX element representing the language control.
 */
function LanguageControl({
  setLanguage,
  language
}) {
  const [options, setOptions] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);
  const [filteredOptions, setFilteredOptions] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);
  const {
    languages,
    haveLanguagesResolved
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useSelect)(select => {
    const query = {
      per_page: -1
    };
    const selectorArgs = ['taxonomy', 'mlib-movie-language', query];
    return {
      languages: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_3__.store).getEntityRecords(...selectorArgs),
      haveLanguagesResolved: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_3__.store).hasFinishedResolution('getEntityRecords', selectorArgs)
    };
  }, []);

  // Set up the languages when resolved.
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (!haveLanguagesResolved || !languages) {
      return;
    }
    const languageOptions = languages.map(currLanguage => ({
      label: (0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__.decodeEntities)(currLanguage.name),
      value: currLanguage.id
    }));
    setOptions([...languageOptions]);
    setFilteredOptions([...languageOptions]);
  }, [haveLanguagesResolved]);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("fieldset", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("legend", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Select Language', 'movie-library')), haveLanguagesResolved && languages ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ComboboxControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Language', 'movie-library'),
    value: language,
    onChange: setLanguage,
    options: filteredOptions,
    onFilterValueChange: inputValue => setFilteredOptions(options.filter(option => option.label.toLowerCase().startsWith(inputValue.toLowerCase())))
  }) : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Spinner, null));
}

/***/ }),

/***/ "./inc/classes/block-editor/blocks/movies-block/components/MovieList.js":
/*!******************************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movies-block/components/MovieList.js ***!
  \******************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ MoviesList; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/html-entities */ "@wordpress/html-entities");
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_4__);







/**
 * Component for displaying a list of movies.
 *
 * This component renders a list of movies based on queried posts and filters
 * them by director if specified.
 *
 * @param {Object} props              - The properties passed to the MoviesList component.
 * @param {Array}  props.queriedPosts - An array of queried movie posts.
 * @param {number} props.director     - The director ID for filtering movies.
 * @return {JSX.Element} JSX element representing the movies list.
 */
function MoviesList({
  queriedPosts,
  director
}) {
  const [posts, setPosts] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(queriedPosts);

  // Filter the movies by director.
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (director !== 0) {
      setPosts(queriedPosts.filter(item => {
        let postDirectors = [];
        try {
          postDirectors = JSON.parse(item.meta['mlib-movie-meta-crew-director']);
        } catch (error) {}
        return Array.isArray(postDirectors) && postDirectors.includes(director);
      }));
    } else {
      setPosts(queriedPosts);
    }
  }, [queriedPosts, director]);
  return posts.length > 0 ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
    className: "movie-library-movies-list"
  }, posts.map(item => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
    key: item.id
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(MovieListItem, {
    title: (0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_4__.decodeEntities)(item.title.rendered),
    thumbnail: item._embedded['wp:featuredmedia'] ? item._embedded['wp:featuredmedia'][0].source_url : '',
    releaseDate: item.meta['mlib-movie-meta-basic-release-date'],
    director: director,
    actors: item.meta['mlib-movie-meta-crew-actor']
  })))) : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('No movies found', 'movie-library'));
}

/**
 * Component for displaying a single movie item.
 *
 * This component displays details of a single movie item, including its title,
 * thumbnail, release date, director, and actors.
 *
 * @param {Object} props             - The properties passed to the MovieListItem component.
 * @param {string} props.title       - The title of the movie.
 * @param {string} props.thumbnail   - The URL of the movie's thumbnail image.
 * @param {string} props.releaseDate - The release date of the movie.
 * @param {number} props.director    - The director ID of the movie.
 * @param {Array}  props.actors      - An array of actor IDs in the movie.
 * @return {JSX.Element} JSX element representing a movie item.
 */
function MovieListItem({
  title,
  thumbnail,
  releaseDate,
  director,
  actors
}) {
  const [directorName, setDirectorName] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)('');
  const [actorNames, setActorNames] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);

  // Select the information about the selected director.
  const {
    directorRecord,
    hasDirectorResolved
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useSelect)(select => {
    const selectorArgs = ['postType', 'mlib-person', director];
    if (director === 0) {
      return {
        directorRecord: {
          title: {
            rendered: ''
          }
        },
        hasDirectorResolved: true
      };
    }
    return {
      directorRecord: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.store).getEntityRecord(...selectorArgs),
      hasDirectorResolved: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.store).hasFinishedResolution('getEntityRecord', selectorArgs)
    };
  });

  // Select the information about the actors for the movie.
  const {
    actorRecords,
    haveActorsResolved
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useSelect)(select => {
    let actorIDs = [];
    try {
      actorIDs = JSON.parse(actors);
    } catch (error) {}
    if (!Array.isArray(actorIDs)) {
      return {
        actorRecords: [],
        haveActorsResolved: true
      };
    }
    const include = actorIDs.slice(0, 2);
    const selectorArgs = ['postType', 'mlib-person', {
      include
    }];
    return {
      actorRecords: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.store).getEntityRecords(...selectorArgs),
      haveActorsResolved: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.store).hasFinishedResolution('getEntityRecords', selectorArgs)
    };
  });

  // Set director name if resolved.
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (!hasDirectorResolved) {
      return;
    }
    setDirectorName((0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_4__.decodeEntities)(directorRecord.title.rendered));
  }, [hasDirectorResolved]);

  // Set actor names if resolved.
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (!haveActorsResolved) {
      return;
    }
    setActorNames(actorRecords.map(actor => (0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_4__.decodeEntities)(actor.title.rendered)));
  }, [haveActorsResolved]);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
    src: thumbnail,
    alt: title
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, `${(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Title', 'movie-library')}: ${title}`), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, `${(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Release Date', 'movie-library')}: ${releaseDate}`), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, `${(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Director', 'movie-library')}: ${directorName}`), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, `${(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Actors', 'movie-library')}: ${actorNames.join(', ')}`));
}

/***/ }),

/***/ "./inc/classes/block-editor/blocks/movies-block/edit.js":
/*!**************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movies-block/edit.js ***!
  \**************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Edit: function() { return /* binding */ Edit; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _components_CountControl__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/CountControl */ "./inc/classes/block-editor/blocks/movies-block/components/CountControl.js");
/* harmony import */ var _components_DirectorControl__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./components/DirectorControl */ "./inc/classes/block-editor/blocks/movies-block/components/DirectorControl.js");
/* harmony import */ var _components_GenreControl__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./components/GenreControl */ "./inc/classes/block-editor/blocks/movies-block/components/GenreControl.js");
/* harmony import */ var _components_LabelControl__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./components/LabelControl */ "./inc/classes/block-editor/blocks/movies-block/components/LabelControl.js");
/* harmony import */ var _components_LanguageControl__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./components/LanguageControl */ "./inc/classes/block-editor/blocks/movies-block/components/LanguageControl.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _components_MovieList__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./components/MovieList */ "./inc/classes/block-editor/blocks/movies-block/components/MovieList.js");












/**
 * WordPress Edit component for a movie-related block.
 *
 * This component is responsible for rendering the block in the block editor and
 * handling user interactions in the editing mode.
 *
 * @param {Object}   props               - The properties passed to the Edit component.
 * @param {Object}   props.attributes    - The block attributes.
 * @param {Function} props.setAttributes - A function to set block attributes.
 *
 * @return {JSX.Element} JSX element representing the block in the editor.
 */
function Edit({
  attributes,
  setAttributes
}) {
  /**
   * Sets the director attribute of the block.
   *
   * @param {number} val
   */
  const setDirector = val => setAttributes({
    director: val !== null && val !== void 0 ? val : 0
  });

  /**
   * Sets the genre attribute of the block.
   *
   * @param {number} val
   */
  const setGenre = val => setAttributes({
    genre: val !== null && val !== void 0 ? val : 0
  });

  /**
   * Sets the label attribute of the block.
   *
   * @param {number} val
   */
  const setLabel = val => setAttributes({
    label: val !== null && val !== void 0 ? val : 0
  });

  /**
   * Sets the language attribute of the block.
   *
   * @param {number} val
   */
  const setLanguage = val => setAttributes({
    language: val !== null && val !== void 0 ? val : 0
  });

  /**
   * Sets the count attribute of the block.
   *
   * Converts count into an integer if possible.
   *
   * @param {number|string} val
   */
  const setCount = val => {
    if (!val || typeof val !== 'number' && typeof val !== 'string') {
      return;
    }
    const intCount = Number.parseInt(val);
    if (Number.isInteger(intCount) && intCount > 0 && intCount <= 10) {
      setAttributes({
        count: intCount
      });
    }
  };
  const {
    director,
    genre,
    label,
    language,
    count
  } = attributes;

  // Select the term id for 'director'.
  const {
    directorTerm,
    hasDirectorTermResolved
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useSelect)(select => {
    const query = {
      slug: 'director'
    };
    const selectorArgs = ['taxonomy', 'mlib-person-career', query];
    return {
      directorTerm: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_2__.store).getEntityRecords(...selectorArgs),
      hasDirectorTermResolved: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_2__.store).hasFinishedResolution('getEntityRecords', selectorArgs)
    };
  }, []);

  // Query the posts each time the user selects a filter.
  const {
    queriedPosts,
    haveQueriedPostsResolved
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useSelect)(select => {
    // Set base query params
    const query = {
      per_page: 5,
      _embed: true
    };

    // Set posts per page.
    if (count && (typeof count === 'number' || typeof count === 'string')) {
      const intCount = Number.parseInt(count);
      if (Number.isInteger(intCount) && intCount > 0 && intCount <= 10) {
        query.per_page = intCount;
      }
    }

    // Set movie genre taxonomy query.
    if (genre && typeof genre === 'number' && Number.isInteger(genre) && genre > 0) {
      query['mlib-movie-genre'] = genre;
    }

    // Set movie label taxonomy query.
    if (label && typeof label === 'number' && Number.isInteger(label) && label > 0) {
      query['mlib-movie-label'] = label;
    }

    // Set language taxonomy query
    if (language && typeof language === 'number' && Number.isInteger(language) && language > 0) {
      query['mlib-movie-language'] = language;
    }
    const selectorArgs = ['postType', 'mlib-movie', query];
    return {
      queriedPosts: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_2__.store).getEntityRecords(...selectorArgs),
      haveQueriedPostsResolved: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_2__.store).hasFinishedResolution('getEntityRecords', selectorArgs)
    };
  }, [genre, label, language, count]);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    ...(0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps)()
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.InspectorControls, {
    key: "movies-block-controls"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    id: "movies-block-controls"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_CountControl__WEBPACK_IMPORTED_MODULE_4__["default"], {
    count: count,
    setCount: setCount
  }), hasDirectorTermResolved && directorTerm && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_DirectorControl__WEBPACK_IMPORTED_MODULE_5__["default"], {
    directorTermID: directorTerm[0].id,
    setDirector: setDirector,
    director: director
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_GenreControl__WEBPACK_IMPORTED_MODULE_6__["default"], {
    setGenre: setGenre,
    genre: genre
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_LabelControl__WEBPACK_IMPORTED_MODULE_7__["default"], {
    setLabel: setLabel,
    label: label
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_LanguageControl__WEBPACK_IMPORTED_MODULE_8__["default"], {
    setLanguage: setLanguage,
    language: language
  }))), haveQueriedPostsResolved ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_MovieList__WEBPACK_IMPORTED_MODULE_10__["default"], {
    queriedPosts: queriedPosts,
    director: director
  }) : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.Spinner, null));
}

/***/ }),

/***/ "./inc/classes/block-editor/blocks/movies-block/index.js":
/*!***************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movies-block/index.js ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./block.json */ "./inc/classes/block-editor/blocks/movies-block/block.json");
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./editor.scss */ "./inc/classes/block-editor/blocks/movies-block/editor.scss");
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./style.scss */ "./inc/classes/block-editor/blocks/movies-block/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./edit */ "./inc/classes/block-editor/blocks/movies-block/edit.js");





(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_1__.name, {
  edit: _edit__WEBPACK_IMPORTED_MODULE_4__.Edit
});

/***/ }),

/***/ "./inc/classes/block-editor/blocks/movies-block/editor.scss":
/*!******************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movies-block/editor.scss ***!
  \******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./inc/classes/block-editor/blocks/movies-block/style.scss":
/*!*****************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movies-block/style.scss ***!
  \*****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ (function(module) {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ (function(module) {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/core-data":
/*!**********************************!*\
  !*** external ["wp","coreData"] ***!
  \**********************************/
/***/ (function(module) {

module.exports = window["wp"]["coreData"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/html-entities":
/*!**************************************!*\
  !*** external ["wp","htmlEntities"] ***!
  \**************************************/
/***/ (function(module) {

module.exports = window["wp"]["htmlEntities"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "./inc/classes/block-editor/blocks/movies-block/block.json":
/*!*****************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movies-block/block.json ***!
  \*****************************************************************/
/***/ (function(module) {

module.exports = JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":3,"name":"movie-library/movies-block","title":"Movies","category":"movie-library","icon":"video-alt","description":"Displays a list of movies.","keywords":["mlib-movie","movies","list"],"version":"0.1.0","textdomain":"movie-library","supports":{"html":false},"attributes":{"count":{"type":"integer","default":5},"director":{"type":"integer","default":0},"genre":{"type":"integer","default":0},"label":{"type":"integer","default":0},"language":{"type":"integer","default":0}},"editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css"}');

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	!function() {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = function(result, chunkIds, fn, priority) {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var chunkIds = deferred[i][0];
/******/ 				var fn = deferred[i][1];
/******/ 				var priority = deferred[i][2];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every(function(key) { return __webpack_require__.O[key](chunkIds[j]); })) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	!function() {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"movies-block/index": 0,
/******/ 			"movies-block/style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = function(chunkId) { return installedChunks[chunkId] === 0; };
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = function(parentChunkLoadingFunction, data) {
/******/ 			var chunkIds = data[0];
/******/ 			var moreModules = data[1];
/******/ 			var runtime = data[2];
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some(function(id) { return installedChunks[id] !== 0; })) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkmovie_library"] = self["webpackChunkmovie_library"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["movies-block/style-index"], function() { return __webpack_require__("./inc/classes/block-editor/blocks/movies-block/index.js"); })
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map
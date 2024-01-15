/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./inc/classes/block-editor/blocks/movie-block/components/MovieSelectorControl.js":
/*!****************************************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movie-block/components/MovieSelectorControl.js ***!
  \****************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ MovieSelectorControl; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/html-entities */ "@wordpress/html-entities");
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__);








/**
 * Component for controlling the selection of a movie.
 *
 * This component renders a ComboboxControl to select a movie based on available
 * options retrieved from the WordPress database.
 *
 * @param {Object}   props          - The properties passed to the MovieSelectorControl component.
 * @param {number}   props.movie    - The ID of the selected movie.
 * @param {Function} props.setMovie - A function to set the selected movie.
 * @return {JSX.Element} JSX element representing the movie selector control.
 */
function MovieSelectorControl({
  movie,
  setMovie
}) {
  const [options, setOptions] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);
  const [filteredOptions, setFilteredOptions] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);
  const {
    movies,
    haveMoviesResolved
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_2__.useSelect)(select => {
    const query = {
      per_page: 100,
      _embed: true
    };
    const selectorArgs = ['postType', 'mlib-movie', query];
    return {
      movies: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.store).getEntityRecords(...selectorArgs),
      haveMoviesResolved: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.store).hasFinishedResolution('getEntityRecords', selectorArgs)
    };
  }, []);

  // Set up Movie options if resolved.
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (!haveMoviesResolved || !movies) {
      return;
    }
    const movieOptions = movies.map(currMovie => ({
      label: (0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__.decodeEntities)(currMovie.title.rendered),
      value: currMovie.id
    }));
    setOptions([...movieOptions]);
    setFilteredOptions([...movieOptions]);
  }, [haveMoviesResolved]);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("fieldset", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("legend", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Select Movie', 'movie-library')), haveMoviesResolved && movies ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ComboboxControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Movie', 'movie-library'),
    value: movie,
    onChange: setMovie,
    options: filteredOptions,
    onFilterValueChange: inputValue => setFilteredOptions(options.filter(option => option.label.toLowerCase().includes(inputValue.toLowerCase())))
  }) : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Spinner, null));
}

/***/ }),

/***/ "./inc/classes/block-editor/blocks/movie-block/components/SingleMovie.js":
/*!*******************************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movie-block/components/SingleMovie.js ***!
  \*******************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ SingleMovie; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/html-entities */ "@wordpress/html-entities");
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_4__);







/**
 * Component for displaying a single movie item.
 *
 * This component displays details of a single movie item, including its title,
 * thumbnail, release date, director, and actors.
 *
 * @param {Object} props             - The properties passed to the SingleMovie component.
 * @param {string} props.title       - The title of the movie.
 * @param {string} props.thumbnail   - The URL of the movie's thumbnail image.
 * @param {string} props.releaseDate - The release date of the movie.
 * @param {Array}  props.directors   - An array of director IDs in the movie.
 * @param {Array}  props.actors      - An array of actor IDs in the movie.
 * @return {JSX.Element} JSX element representing a movie item.
 */
function SingleMovie({
  title,
  thumbnail,
  releaseDate,
  directors,
  actors
}) {
  const [directorNames, setDirectorNames] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);
  const [actorNames, setActorNames] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)([]);

  // Select the information about the actors for the movie.
  const {
    directorRecords,
    haveDirectorsResolved
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_2__.useSelect)(select => {
    let directorIDs = [];
    try {
      directorIDs = JSON.parse(directors);
    } catch (error) {}
    if (!Array.isArray(directorIDs)) {
      return {
        directorRecords: [],
        haveDirectorsResolved: true
      };
    }
    const include = directorIDs.slice(0, 2);
    const selectorArgs = ['postType', 'mlib-person', {
      include
    }];
    return {
      directorRecords: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.store).getEntityRecords(...selectorArgs),
      haveDirectorsResolved: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.store).hasFinishedResolution('getEntityRecords', selectorArgs)
    };
  });

  // Select the information about the actors for the movie.
  const {
    actorRecords,
    haveActorsResolved
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_2__.useSelect)(select => {
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

  // Set Director names if resolved.
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (!haveDirectorsResolved) {
      return;
    }
    setDirectorNames(directorRecords.map(director => (0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_4__.decodeEntities)(director.title.rendered)));
  }, [haveDirectorsResolved]);

  // Set actor names if resolved.
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (!haveActorsResolved) {
      return;
    }
    setActorNames(actorRecords.map(actor => (0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_4__.decodeEntities)(actor.title.rendered)));
  }, [haveActorsResolved]);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "movie-library-single-movie"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
    src: thumbnail,
    alt: title
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, `${(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Title', 'movie-library')}: ${title}`), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, `${(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Release Date', 'movie-library')}: ${releaseDate}`), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, `${(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Director', 'movie-library')}: ${directorNames.join(', ')}`), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, `${(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Actors', 'movie-library')}: ${actorNames.join(', ')}`));
}

/***/ }),

/***/ "./inc/classes/block-editor/blocks/movie-block/edit.js":
/*!*************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movie-block/edit.js ***!
  \*************************************************************/
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
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/html-entities */ "@wordpress/html-entities");
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _components_MovieSelectorControl__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./components/MovieSelectorControl */ "./inc/classes/block-editor/blocks/movie-block/components/MovieSelectorControl.js");
/* harmony import */ var _components_SingleMovie__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./components/SingleMovie */ "./inc/classes/block-editor/blocks/movie-block/components/SingleMovie.js");









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
   * Sets the movie attribute of the block.
   *
   * @param {number} val
   */
  const setMovie = val => setAttributes({
    movie: val !== null && val !== void 0 ? val : attributes.movie
  });
  const {
    movie
  } = attributes;

  // Query the posts each time the user selects a filter.
  const {
    queriedPost,
    hasPostResolved
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useSelect)(select => {
    // Set base query params
    const query = {
      _embed: true
    };

    // Set language taxonomy query
    if (!movie || typeof movie !== 'number' || !Number.isInteger(movie) || movie <= 0) {
      return {
        queriedPost: {},
        hasPostResolved: true
      };
    }
    const selectorArgs = ['postType', 'mlib-movie', movie, query];
    return {
      queriedPost: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_2__.store).getEntityRecord(...selectorArgs),
      hasPostResolved: select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_2__.store).hasFinishedResolution('getEntityRecord', selectorArgs)
    };
  }, [movie]);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    ...(0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps)()
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.InspectorControls, {
    key: "movies-block-controls"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "movie-block-controls"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_MovieSelectorControl__WEBPACK_IMPORTED_MODULE_6__["default"], {
    movie: movie,
    setMovie: setMovie
  }))), hasPostResolved && queriedPost.title && queriedPost._embedded && queriedPost.meta ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SingleMovie__WEBPACK_IMPORTED_MODULE_7__["default"], {
    title: (0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_5__.decodeEntities)(queriedPost.title ? queriedPost.title.rendered : 'No movie selected'),
    thumbnail: queriedPost._embedded && queriedPost._embedded['wp:featuredmedia'] ? queriedPost._embedded['wp:featuredmedia'][0].source_url : '',
    releaseDate: queriedPost.meta['mlib-movie-meta-basic-release-date'],
    directors: queriedPost.meta['mlib-movie-meta-crew-director'],
    actors: queriedPost.meta['mlib-movie-meta-crew-actor']
  }) : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Spinner, null));
}

/***/ }),

/***/ "./inc/classes/block-editor/blocks/movie-block/index.js":
/*!**************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movie-block/index.js ***!
  \**************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./block.json */ "./inc/classes/block-editor/blocks/movie-block/block.json");
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./editor.scss */ "./inc/classes/block-editor/blocks/movie-block/editor.scss");
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./style.scss */ "./inc/classes/block-editor/blocks/movie-block/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./edit */ "./inc/classes/block-editor/blocks/movie-block/edit.js");





(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_1__.name, {
  edit: _edit__WEBPACK_IMPORTED_MODULE_4__.Edit
});

/***/ }),

/***/ "./inc/classes/block-editor/blocks/movie-block/editor.scss":
/*!*****************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movie-block/editor.scss ***!
  \*****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./inc/classes/block-editor/blocks/movie-block/style.scss":
/*!****************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movie-block/style.scss ***!
  \****************************************************************/
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

/***/ "./inc/classes/block-editor/blocks/movie-block/block.json":
/*!****************************************************************!*\
  !*** ./inc/classes/block-editor/blocks/movie-block/block.json ***!
  \****************************************************************/
/***/ (function(module) {

module.exports = JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":3,"name":"movie-library/movie-block","title":"Single movie","category":"movie-library","icon":"video-alt","description":"Displays a single movie.","keywords":["mlib-movie","movie","single"],"version":"0.1.0","textdomain":"movie-library","supports":{"html":false},"attributes":{"movie":{"type":"integer","default":0}},"editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css"}');

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
/******/ 			"movie-block/index": 0,
/******/ 			"movie-block/style-index": 0
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
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["movie-block/style-index"], function() { return __webpack_require__("./inc/classes/block-editor/blocks/movie-block/index.js"); })
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map
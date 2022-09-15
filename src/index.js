/**
 * External dependencies
 */
import React, { useState } from 'react';
import { render } from 'react-dom';

/**
 * Internal dependencies
 */
import './index.scss';
import { SearchForm } from './search/searchForm';
import { SearchResults } from './search/searchResults';
import { FileDisplay } from './search/fileDisplay';

const RootComponent = () => {
	const [results, setResults] = useState([]);
	const [fileContent, setFileContent] = useState('');
	const [isSearching, setIsSearching] = useState(false);

	return (
		<>
			<SearchForm
				setResults={setResults}
				isSearching={isSearching}
				setIsSearching={setIsSearching}
			/>
			{results && (
				<SearchResults
					results={results}
					setIsSearching={setIsSearching}
					setFileContent={setFileContent}
				/>
			)}
			{fileContent && <FileDisplay fileContent={fileContent} />}
		</>
	);
};
const domContainer = document.querySelector('#log-search');
render(<RootComponent />, domContainer);

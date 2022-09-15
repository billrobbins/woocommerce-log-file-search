/**
 * Internal dependencies
 */
import { getFile } from '../utilities/DataStore';

export const SearchResults = (props) => {
	const results = props.results;

	const handleClick = (result) => {
		props.setIsSearching(true);
		if (result === 'Sorry, no results found.') {
			props.setIsSearching(false);
			return;
		}
		getFile({ file: result })
			.then((resp) => props.setFileContent(resp))
			.then(props.setIsSearching(false));
	};

	return (
		<ul>
			{results.map((result, index) => (
				<li key={index}>
					<button onClick={() => handleClick(result)}>
						{result}
					</button>
				</li>
			))}
		</ul>
	);
};

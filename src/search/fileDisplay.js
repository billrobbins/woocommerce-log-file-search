export const FileDisplay = (props) => {
	const styles = `#log-viewer { display: none; }`;
	return (
		<div className="log-file-viewer">
			<style>{styles}</style>
			<pre>{props.fileContent}</pre>
		</div>
	);
};

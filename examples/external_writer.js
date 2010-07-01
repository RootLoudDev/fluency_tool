/**
 * This script writes to the document that calls it.
 * It is intended to accomodate the EOLAS
 * patent workarounds in IE6. For more information visit:
 *    http://en.wikipedia.org/wiki/EOLAS
 */

function ExternalDocumentWrite( appletCode )
{
	document.write( appletCode );
}

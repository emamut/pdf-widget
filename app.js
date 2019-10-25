jQuery(document).ready(function ($) {
  var selector = '#myPDF',
  pdfURL = $(selector).data('pdf-url'),
  url = $(selector).data('url'),
  options = {
    pdfOpenParams: {
      view: 'FitV',
      page: '1',
      pagemode: 'thumbs',
      toolbar: 0
    }
  }
  PDFObject.embed(pdfURL, selector, options)

  $('#pdf-widget-container').find('#link').on('click', function (e) {
    e.preventDefault()
    window.open(url, '_blank');
  })
})
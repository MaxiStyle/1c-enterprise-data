<?php

namespace MaxiStyle\EnterpriseData;

use DOMException;
use MaxiStyle\EnterpriseData\Exception\XMLGenerationException;
use MaxiStyle\EnterpriseData\Exception\UnsupportedDocumentException;
use MaxiStyle\EnterpriseData\Builders\DocumentBuilderInterface;
use DOMDocument;
use DOMElement;

/**
 * Основной класс для генерации всего XML документа в формате 1C EnterpriseData
 */
class DocumentGenerator
{
    private string $version;
    private string $format;
    private array $builders = [];

    public const DOCUMENT_TYPE_INVOICE_OUT = 'invoiceout';
    public const DOCUMENT_TYPE_INVOICE_IN = 'invoicein';

    public function __construct(string $version = '1.6', string $format = null)
    {
        $this->version = $version;
        $this->format = $format ?: "http://v8.1c.ru/edi/edi_stnd/EnterpriseData/{$version}";

        // Register default builders
        $this->registerDefaultBuilders();
    }

    /**
     * Register a document builder
     */
    public function registerBuilder(string $documentType, DocumentBuilderInterface $builder): void
    {
        $this->builders[$documentType] = $builder;
    }

    /**
     * Generate XML for document
     *
     * @param object|array $documents Single document or array of documents
     * @return string
     * @throws XMLGenerationException|UnsupportedDocumentException
     */
    public function generate(object|array $documents): string
    {
        $documentsArray = is_array($documents) ? $documents : [$documents];

        // Validate all documents have registered builders
        foreach ($documentsArray as $document) {
            $documentType = $this->getDocumentType($document);
            if (!isset($this->builders[$documentType])) {
                throw new UnsupportedDocumentException("No builder registered for document type: {$documentType}");
            }
        }

        try {
            $dom = new DOMDocument('1.0', 'utf-8');
            $dom->formatOutput = true;

            $message = $dom->createElement('Message');
            $message->setAttribute('xmlns:msg', 'http://www.1c.ru/SSL/Exchange/Message');
            $message->setAttribute('xmlns:xs', 'http://www.w3.org/2001/XMLSchema');
            $message->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
            $dom->appendChild($message);

            $this->addHeader($dom, $message);
            $this->addBody($dom, $message, $documentsArray);

            return $dom->saveXML();
        } catch (\Exception $e) {
            throw new XMLGenerationException('XML generation failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Save XML to file with BOM for correct Cyrillic display in 1C
     */
    public function saveToFile(string $xml, string $filename): bool
    {
        $bom = pack('H*', 'EFBBBF');
        $xmlWithBom = $bom . $xml;
        return file_put_contents($filename, $xmlWithBom) !== false;
    }

    /**
     * Generate and save document(s) to file
     */
    public function generateToFile(object|array $documents, string $filename): bool
    {
        $xml = $this->generate($documents);
        return $this->saveToFile($xml, $filename);
    }

    /**
     * Создаем массив сущностей и их билдеров
     * @return void
     */
    private function registerDefaultBuilders(): void
    {
        $this->registerBuilder(
            self::DOCUMENT_TYPE_INVOICE_OUT,
            new \MaxiStyle\EnterpriseData\Builders\InvoiceOutBuilder()
        );
        $this->registerBuilder(
            self::DOCUMENT_TYPE_INVOICE_IN,
            new \MaxiStyle\EnterpriseData\Builders\InvoiceInBuilder()
        );
    }

    /**
     * По классу объекта сущности определяем билдер
     * @param object $document
     * @return string
     */
    private function getDocumentType(object $document): string
    {
        $class = get_class($document);
        $class = substr($class, strrpos($class, '\\') + 1);
        return strtolower($class);
    }

    /**
     * @throws DOMException
     */
    private function addHeader(DOMDocument $dom, DOMElement $parent): void
    {
        $header = $dom->createElement('msg:Header');
        $parent->appendChild($header);

        $this->createElement($dom, $header, 'msg:Format', $this->format);
        $this->createElement(
            $dom,
            $header,
            'msg:CreationDate',
            date('Y-m-d\TH:i:s')
        );
        $this->createElement(
            $dom,
            $header,
            'msg:AvailableVersion',
            $this->version
        );
    }

    /**
     * @throws DOMException
     */
    private function addBody(
        DOMDocument $dom,
        DOMElement $parent,
        array $documents
    ): void {
        $body = $dom->createElement('Body');
        $body->setAttribute('xmlns', $this->format);
        $parent->appendChild($body);

        foreach ($documents as $document) {
            $documentType = $this->getDocumentType($document);
            $builder = $this->builders[$documentType];
            $builder->build($dom, $body, $document);
        }
    }

    /**
     * @throws DOMException
     */
    protected function createElement(DOMDocument $dom, DOMElement $parent, string $name, string $value): DOMElement
    {
        $element = $dom->createElement(
            $name,
            htmlspecialchars($value, ENT_XML1, 'UTF-8')
        );
        $parent->appendChild($element);
        return $element;
    }
}

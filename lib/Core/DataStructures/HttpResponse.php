<?php
namespace memeserver\Core\DataStructures;
use memeserver\Core\Data\HTTPReasons;
use memeserver\Core\Logging\Logger;
use memeserver\Core\Logging\LogMode;
use memeserver\Core\Settings;

/**
 * Class HttpResponse
 * @package memeserver\Core\DataStructures
 */
class HttpResponse {
    /**
     * @var int
     */
    const HTTP_VERSION = 1.1;

    /**
     * @var KeyValuePairs
     */
    private $headers;

    /**
     * @var string
     */
    private $body;

    /**
     * @var HttpRequest
     */
    private $request;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var array
     */
    private $cookies;

    /**
     * @var Settings
     */
    private $settings;

    /**
     * Response constructor.
     * @param Logger $logger
     * @param HttpRequest $httpRequest
     * @param Settings $settings
     */
    public function __construct(Logger $logger, HttpRequest $httpRequest, Settings $settings) {
        $this->logger = $logger;
        $this->request = $httpRequest;
        $this->settings = $settings;
        $this->headers = new KeyValuePairs();
    }

    /**
     * @param string $body
     * @return HttpResponse
     */
    public function setBody(string $body): self {
        $this->body = $body;
        return $this;
    }

    /**
     * @param string $algorithm
     * @return HttpResponse
     */
    public function encodeBody(string $algorithm): self {
        switch ($algorithm) {
            case "gzip":
                if(function_exists('gzencode') && $this->request->h()->getAcceptedEncoding()->inArray('gzip')) {
                    $this->body = gzencode($this->body);
                    $this->headers->create("Content-Encoding", 'gzip');
                }
                break;
            case "deflate":
                if(function_exists('gzcompress') && $this->request->h()->getAcceptedEncoding()->inArray('deflate')) {
                    $this->body = gzcompress($this->body);
                    $this->headers->create("Content-Encoding", 'deflate');
                }
                break;
            default:
                $this->logger->warn(LogMode::LOG_DEVELOPMENT, "Algorithm not identified in Response::encodeBody. Provided: $algorithm");
                break;
        }

        return $this;
    }

    /**
     * @param int $code
     * @return HttpResponse
     */
    public function setStatus(int $code): self {
        $this->headers->create("meta_Code", $code);
        $reason = HTTPReasons::HTTP_REASON[$code];

        if($reason === null) {
            $this->logger->warn(LogMode::LOG_DEVELOPMENT, "$code not identified as a proper response code. Using a 500 Status code.");

            $this->headers->create("meta_Code", 500);
            $this->headers->create("meta_Reason", HTTPReasons::HTTP_REASON[500]);

            return $this;
        }

        $this->headers->create("meta_Reason", $reason);

        return $this;
    }

    /**
     * @param string $mime
     * @return $this
     */
    public function setContentType(string $mime) {
        $this->headers->create("Content-Type", $mime);

        return $this;
    }

    /**
     * @param string $header
     * @return bool
     */
    public function issetHeader(string $header) {
        return $this->headers->isSet($header);
    }

    /**
     * @param string $name
     * @param string $value
     * @param array $options
     * @return HttpResponse
     */
    public function setCookie(string $name, string $value, array $options): self {
        $this->cookies[$name] = [$value, $options];

        return $this;
    }

    /**
     * @return HttpResponse
     */
    public function initCookieHeader(): self {
        $header = '';

        foreach ($this->cookies as $name => $v) {
            $header .= "$name={$v[0]}";
            $options = array_change_key_case($v[1]);

            foreach ($options as $option => $value) {
                if (\is_int($name)) {
                    $header .= "; $value,";
                } else {
                    $header .= "; $option=$value,";
                }
            }

            if (isset($options["max-age"]) && !isset($options["expires"])) {
                $header .= "; expires=".date("r", time() + $options["max-age"]);
            } else {
                $header .= "; expires=" . $this->settings->getCookieMaxAge();
            }
        }

        $header = \trim($header, ',');

        $this->headers->create("Set-Cookie", $header);

        return $this;
    }

    /**
     * @return string
     */
    public function createRequestETag(): string {
        return crc32($this->body);
    }

    /**
     * @param string $etag
     * @return HttpResponse
     */
    public function setETag(string $etag): self {
        $this->headers->create("ETag", $etag);
        return $this;
    }

    /**
     * @return HttpResponse
     */
    public function setContentLength(): self {
        $this->headers->create("Content-Length", strlen($this->body));

        return $this;
    }

    public function getRawResponse(): string {
        $rawString = "";
        $statusCode = $this->headers->get("meta_Code");
        $statusReason = $this->headers->get("meta_Reason");

        // First up, basic HTTP Status field
        $rawString .= 'HTTP/' . static::HTTP_VERSION . " $statusCode $statusReason \r\n";

        // Get the internal array, to iterate
        $kvArray = $this->headers->getInternalRawArray();

        // Iterate through them...
        foreach ($kvArray as $key => $value) {
            if($key === "meta_Code" || $key === "meta_Reason")
                continue;
            $rawString .= "$key: $value\r\n";
        }

        // Lastly add another \r\n and append the body
        $rawString .= "\r\n{$this->body}";

        return $rawString;
    }
}
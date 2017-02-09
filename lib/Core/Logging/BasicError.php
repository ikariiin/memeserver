<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 8/2/17
 * Time: 11:47 AM
 */

namespace memeserver\Core\Logging;


class BasicError implements Loggable {
    /**
     * @var int
     */
    private $errNo;

    /**
     * @var string
     */
    private $errStr;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * BasicError constructor.
     * @param Logger $logger
     * @param int $errNo
     * @param string $errStr
     */
    public function __construct(Logger $logger, int $errNo = 0, string $errStr = "") {
        $this->errNo = $errNo;
        $this->errStr = $errStr;
        $this->logger = $logger;
    }

    public function log() {
        $this->logger->exceptionHandler($this->getException());
    }

    /**
     * @return \Exception
     */
    public function getException(): \Exception {
        return (new \Exception($this->errStr, $this->errNo));
    }

    /**
     * @return int
     */
    public function getErrNo(): int {
        return $this->errNo;
    }

    /**
     * @return string
     */
    public function getErrStr(): string {
        return $this->errStr;
    }
}
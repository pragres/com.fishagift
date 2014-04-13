<?php

include_once framework::resolve('orm/Trace.php');

/**
 * A tool box to manage the user Trace structure
 *
 * @author Salvi
 * */
class Tracer{
	/**
	 * Check if the traceStack structure is created
	 *
	 * @author Salvi
	 * @return boolean
	 * */
	static public function isTraceStackCreated(){
		return framework::session_exists('traceStack');
	}

	/**
	 * Create an empty traceStack in the session structure or inicialize an existing one
	 *
	 * @author Salvi
	 * */
	static public function createTraceStack(){
		framework::session_set('traceStack', Array());
	}

	/**
	 * Creates a new trace in the structure
	 *
	 * @author Salvi
	 * */
	static public function createTrace(){
		if(!self::isTraceStackCreated()) {
			self::createTraceStack();
			//throw new Exception("TraceStack structure is undefined");
		}

		// do not insert a trace for the same location when the user refreshe the browser
		$lastTrace = self::returnLastTrace();
		if($lastTrace!=NULL){
			$currentLocation = framework::getValue('package') .'/'. framework::getValue('page');
			if($lastTrace->getLocation() == $currentLocation) return;
		}

		// insert trace
		$traceStack = framework::session_get('traceStack');
		array_push($traceStack, new Trace());
		framework::session_set('traceStack', $traceStack);
	}

	/**
	 * Return last trace in the Stack
	 *
	 * @author Salvi
	 * @return Trace
	 * */
	static public function returnLastTrace(){
		if(!self::isTraceStackCreated()) throw new Exception("TraceStack structure is undefined");

		$traceStack = framework::session_get('traceStack');
		if(count($traceStack)<2) return NULL;
		return $traceStack[count($traceStack)-2];
	}

	/**
	 * Return all the traceStack as an Array
	 *
	 * @author Salvi
	 * @return Array
	 * */
	static public function returnTraceStack(){
		if(!self::isTraceStackCreated()) throw new Exception("TraceStack structure is undefined");

		return array_reverse(framework::session_get('traceStack'));
	}

	/**
	 * Return the formatted traceStack structure in HTML
	 *
	 * @author Salvi
	 * @return String, HTML representation of the whole traceStack structure
	 * */
	static public function returnTraceStackHTML(){
		if(!self::isTraceStackCreated()) throw new Exception("TraceStack structure is undefined");

		$traceStack = self::returnTraceStack();
		$htmlToReturn = "";
		foreach ($traceStack as $trace) $htmlToReturn .= $trace . "<br/>\n";

		return $htmlToReturn;
	}
}
<?php

// For a content file called `project.txt`
// In general the class name is {{ProjectFileName}}Page

class ProjectPage extends Page {
  // all methods of the Page class are inherited and can be overridden here now.

  public function cover() {
    return $this->image('cover');
  }
}

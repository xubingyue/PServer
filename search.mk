#parameter list
SUBMODS ?=
#parameter list

CLEANTARGET = clean
INSTALLTARGET = install
TAGSTARGET = tags
COVTARGET = cov

SUBMODSCLEAN = $(patsubst %, %.$(CLEANTARGET), $(SUBMODS)) 
SUBMODSINSTALL = $(patsubst %, %.$(INSTALLTARGET), $(SUBMODS)) 
SUBMODSTAGS = $(patsubst %, %.$(TAGSTARGET), $(SUBMODS))
SUBMODSCOV = $(patsubst %, %.$(COVTARGET), $(SUBMODS))

.PHONY: all $(CLEANTARGET) $(INSTALLTARGET) $(TAGSTARGET) $(COVTARGET) $(SUBMODS)

all: $(SUBMODS)

$(CLEANTARGET): $(SUBMODSCLEAN)

$(INSTALLTARGET): $(SUBMODSINSTALL)

$(TAGSTARGET): $(SUBMODSTAGS)

$(COVTARGET): $(SUBMODSCOV)

$(SUBMODS):
	cd $@ && $(MAKE);

$(SUBMODSCOV): 
	cd $(patsubst %.$(COVTARGET),%, $@)  && $(MAKE) $(COVTARGET);

$(SUBMODSTAGS): 
	cd $(patsubst %.$(TAGSTARGET),%, $@)  && $(MAKE) $(TAGSTARGET);

$(SUBMODSCLEAN): 
	cd $(patsubst %.$(CLEANTARGET),%, $@)  && $(MAKE) $(CLEANTARGET);

$(SUBMODSINSTALL): 
	cd $(patsubst %.$(INSTALLTARGET),%, $@)  && $(MAKE) $(INSTALLTARGET);

